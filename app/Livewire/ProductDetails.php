<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
class ProductDetails extends Component
{
    public $product;
    public $quantity = 1;
    public $addedToCart = false;

    public function mount(Product $product)
    {
        $this->product = $product;

        //Check if product is already in user's cart
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->where('status', 'active')->first();
            if ($cart && $cart->items()->where('product_id', $product->id)->exists()) {
                $this->addedToCart = true;
            }
        }
    }

    // Increase quantity
    public function increment()
    {
        if ($this->quantity < $this->product->quantityavailable) {
            $this->quantity++;
        } else {
            session()->flash('error', 'You cannot select more than available stock.');
        }
    }

    // Decrease quantity (minimum 1)
    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    // Add to cart
    public function addToCart()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Sign in first.');
            return;
        }

        // Check quantity against available stock
        if ($this->quantity > $this->product->quantityavailable) {
            session()->flash('error', 'Not enough stock available.');
            return;
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'status' => 'active']
        );

        $cart->items()->updateOrCreate(
            ['product_id' => $this->product->id],
            ['quantity' => $this->quantity]
        );

        $this->addedToCart = true; // disable button
        session()->flash('success', 'Added to cart!');
    }


    public function render()
    {
        return view('livewire.product-details');
    }
}
