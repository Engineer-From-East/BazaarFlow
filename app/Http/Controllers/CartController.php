<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Display the cart
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart')); // <-- Updated to point to the new cart folder
    }

    // Add a product to the cart
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // If item exists in cart, increment quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            // Otherwise, add the item to the cart (Now with Images!)
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image // <-- Grabbing the newly added image path
            ];
        }

        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', $product->name . ' added to cart successfully!');
    }

    // Remove a product from the cart
    public function remove($id)
    {
        $cart = session()->get('cart');
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
}