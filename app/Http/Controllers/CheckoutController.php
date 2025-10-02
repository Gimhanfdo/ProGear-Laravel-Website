<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Product;
use App\Models\MongoOrder;
use App\Models\MongoOrderItem;
use App\Events\OrderPlaced;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to checkout.');
        }

        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // For mobile API, return JSON
        if ($request->wantsJson()) {
            $cartData = $cart->items->map(function ($item) {
                $price = $item->product->price;
                if ($item->product->discountpercentage > 0) {
                    $price *= (1 - $item->product->discountpercentage / 100);
                }
                return [
                    'product_id' => $item->product->id,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $price,
                    'total_price' => $price * $item->quantity,
                ];
            });

            return response()->json([
                'cart' => $cartData,
                'subtotal' => $cartData->sum(fn($i) => $i['total_price']),
            ]);
        }

        return view('checkout.index', ['cart' => $cart]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'shippingaddress' => 'required|string|max:255',
            'paymentmethod' => 'required|in:cash,card',
            'cardnumber' => 'nullable|required_if:paymentmethod,card|digits:16',
            'cvv' => 'nullable|required_if:paymentmethod,card|digits:3',
            'expirydate' => 'nullable|required_if:paymentmethod,card',
        ]);

        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();

        try {
            // 1. Create order
            $order = Order::create([
                'user_id' => $user->id,
                'orderdate' => now(),
                'total' => $cart->items->sum(function ($item) {
                    $price = $item->product->price;
                    if ($item->product->discountpercentage > 0) {
                        $price *= (1 - $item->product->discountpercentage / 100);
                    }
                    return $price * $item->quantity;
                }),
                'shippingaddress' => $request->shippingaddress,
                'orderstatus' => 'pending',
            ]);

            $mongoOrder = MongoOrder::create([
                'user_id' => $user->id,
                'orderdate' => now(),
                'total' => $order->total,
                'shippingaddress' => $request->shippingaddress,
                'orderstatus' => 'pending',
            ]);

            // 2. Save order items + update stock
            foreach ($cart->items as $cartItem) {
                if ($cartItem->product->quantityavailable < $cartItem->quantity) {
                    throw new \Exception("Not enough stock for {$cartItem->product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product->id,
                    'quantity' => $cartItem->quantity,
                ]);

                MongoOrderItem::create([
                    'order_id' => $mongoOrder->_id, // Mongo’s primary key
                    'product_id' => $cartItem->product->id,
                    'quantity' => $cartItem->quantity,
                ]);

                $cartItem->product->decrement('quantityavailable', $cartItem->quantity);
            }

            // 3. Save payment
            Payment::create([
                'order_id' => $order->id,
                'total' => $order->total,
                'paymentmethod' => $request->paymentmethod,
            ]);

            // 4. Clear cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            // Different response based on client
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully',
                    'order_id' => $order->id,
                    'total' => $order->total,
                ]);
            }

            // After creating the order
            OrderPlaced::dispatch($order);

            return redirect()->route('confirmation')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                ], 500);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    public function mobilestore(Request $request)
    {
        $request->validate([
            'shippingaddress' => 'required|string|max:255',
            'paymentmethod' => 'required|string',
        ]);

        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Cart is empty'], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();

        try {
            // 1. Create order
            $order = Order::create([
                'user_id' => $user->id,
                'orderdate' => now(),
                'total' => $cart->items->sum(function ($item) {
                    $price = $item->product->price;
                    if ($item->product->discountpercentage > 0) {
                        $price *= (1 - $item->product->discountpercentage / 100);
                    }
                    return $price * $item->quantity;
                }),
                'shippingaddress' => $request->shippingaddress,
                'orderstatus' => 'pending',
            ]);

            // 2. Save order items + update stock
            foreach ($cart->items as $cartItem) {
                if ($cartItem->product->quantityavailable < $cartItem->quantity) {
                    throw new \Exception("Not enough stock for {$cartItem->product->name}");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product->id,
                    'quantity' => $cartItem->quantity,
                ]);

                $cartItem->product->decrement('quantityavailable', $cartItem->quantity);
            }

            // 3. Save payment
            Payment::create([
                'order_id' => $order->id,
                'total' => $order->total,
                'paymentmethod' => $request->paymentmethod,
            ]);

            // 4. Clear cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            // Different response based on client
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully',
                    'order_id' => $order->id,
                    'total' => $order->total,
                ]);
            }

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage(),
                ], 500);
            }

            return back()->with('error', $e->getMessage());
        }
    }
}
