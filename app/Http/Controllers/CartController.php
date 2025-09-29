<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get active cart
    public function index(Request $request)
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'active']
        );

        $cart->load('items.product');

        if ($request->wantsJson()) {
            return response()->json(['cart' => $cart]);
        }

        return view('cart.index', ['cart' => $cart]);
    }

    public function fetchCartData($userId)
    {
        $cart = Cart::firstOrCreate(
            ['user_id' => $userId, 'status' => 'active']
        );

        return $cart->load('items.product');
    }

    // Add item to cart with stock check
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'active']
        );

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $newQuantity = $item->quantity + $request->quantity;

            if ($newQuantity > $product->quantityavailable) {
                return $request->wantsJson()
                    ? response()->json(['success' => false, 'message' => 'Not enough stock available.'], 400)
                    : back()->with('error', 'Not enough stock available.');
            }

            $item->update(['quantity' => $newQuantity]);
        } else {
            if ($request->quantity > $product->quantityavailable) {
                return $request->wantsJson()
                    ? response()->json(['success' => false, 'message' => 'Not enough stock available.'], 400)
                    : back()->with('error', 'Not enough stock available.');
            }

            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        $cart->load('items.product');

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'cart' => $cart]);
        }

        session()->flash('success', 'Added to cart!');
        return redirect()->back();
    }

    //Update quantity with stock + ownership check
    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        //Ownership check
        if ($item->cart->user_id !== Auth::id()) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Unauthorized.'], 403)
                : back()->with('error', 'Unauthorized action.');
        }

        $product = $item->product;

        if ($request->quantity > $product->quantityavailable) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Not enough stock available.'], 400)
                : back()->with('error', 'Not enough stock available.');
        }

        $item->update(['quantity' => $request->quantity]);
        $cart = $item->cart->load('items.product');

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'cart' => $cart]);
        }

        session()->flash('success', 'Quantity updated!');
        return redirect()->back();
    }

    //Remove item with ownership check
    public function remove(Request $request, CartItem $item)
    {
        //Ownership check
        if ($item->cart->user_id !== Auth::id()) {
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Unauthorized.'], 403)
                : back()->with('error', 'Unauthorized action.');
        }

        $item->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Item removed.']);
        }

        session()->flash('success', 'Item removed from cart.');
        return redirect()->back();
    }

    //Clear cart
    public function clear(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->where('status', 'active')->first();

        if ($cart) {
            $cart->items()->delete();
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Cart cleared.']);
        }

        session()->flash('success', 'Cart cleared.');
        return redirect()->back();
    }
}
