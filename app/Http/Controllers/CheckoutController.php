<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // 1. Display the checkout page
    public function index()
    {
        $cart = session()->get('cart', []);
        
        // Security check: If cart is empty, kick them back to the shop
        if (empty($cart)) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty! Add some perfumes first.');
        }

        return view('checkout.index', compact('cart'));
    }

    // 2. Process the order and save to database
    public function process(Request $request)
    {
        // Validate the incoming form data
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        $cart = session()->get('cart', []);
        
        // Double check cart isn't empty before processing
        if (empty($cart)) {
            return redirect()->route('shop.index');
        }

        // Calculate the exact total amount from the session cart
        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // Create the official Order in the database AND capture it in a variable!
        $order = Order::create([
            'user_id' => Auth::id(), // Links the order to the logged-in user
            'phone_number' => $request->phone,       
            'shipping_address' => $request->address, 
            'total_amount' => $total,
            'status' => 'pending' // All new orders start as pending
        ]);

        // NEW: Loop through the session cart and save each item to the database
        foreach ($cart as $id => $details) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id, // The ID of the order we just created above
                'product_id' => $id,      // The ID of the perfume
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        // Empty the cart so they don't accidentally buy it again
        session()->forget('cart');

        // Redirect to their dashboard with a massive success message
        return redirect()->route('dashboard')->with('success', 'Order Placed Successfully! We will deliver it soon.');
    }
}