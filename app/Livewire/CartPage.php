<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use App\Models\CartItem;

class CartPage extends Component
{
    public $cart;

    protected $cartController;

    public function mount(CartController $cartController)
    {
        $this->cartController = $cartController;
        $this->fetchCart();
    }

    public function fetchCart()
    {
        if (!Auth::check()) {
            $this->cart = null;
            session()->flash('error', 'Please log in to view your cart.');
            return;
        }

        $this->cart = $this->cartController->fetchCartData(Auth::id());
    }

    public function increaseQuantity($itemId)
    {
        $this->updateQuantity($itemId, 1);
    }

    public function decreaseQuantity($itemId)
    {
        $this->updateQuantity($itemId, -1);
    }

    private function updateQuantity($itemId, $change)
    {
        // Load cart relation to prevent null errors
        $item = CartItem::with('cart')->find($itemId);

        if (!$item || !$item->cart || $item->cart->user_id !== Auth::id()) {
            session()->flash('error', 'Cart item not found.');
            return;
        }

        $newQuantity = max(1, $item->quantity + $change);

        // Merge quantity into request for controller method
        $request = request()->merge(['quantity' => $newQuantity]);
        $response = $this->cartController->update($request, $item);

        // Reload cart for Livewire
        $this->fetchCart();

        // Show success/error feedback from controller
        if (session()->has('error')) {
            session()->flash('error', session('error'));
        } else {
            session()->flash('success', 'Quantity updated!');
        }
    }

    public function removeItem($itemId)
    {
        $item = CartItem::with('cart')->find($itemId);

        if (!$item || !$item->cart || $item->cart->user_id !== Auth::id()) {
            session()->flash('error', 'Cart item not found.');
            return;
        }

        $response = $this->cartController->remove(request(), $item);
        $this->fetchCart();

        if (!session()->has('error')) {
            session()->flash('success', 'Item removed from cart.');
        }
    }

    public function clearCart()
    {
        $this->cartController->clear(request());
        $this->fetchCart();

        session()->flash('success', 'Cart cleared.');
    }

    public function render()
    {
        return view('livewire.cart-page', ['cart' => $this->cart]);
    }
}
