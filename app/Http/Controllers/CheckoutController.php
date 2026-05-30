<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // Display the checkout form
    public function index()
    {
        $cart = session()->get('cart');
        if(!$cart || count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }
        return view('shop.checkout', compact('cart'));
    }

    // Process the final order
    public function process(Request $request)
    {
        $cart = session()->get('cart');
        
        // --- NEW SAFETY CHECK ---
        // If the cart is empty or expired, send them back to the shop instead of crashing
        if(!$cart || count($cart) == 0) {
            return redirect()->route('shop.index')->with('error', 'Your session expired or cart is empty. Please add items again!');
        }
        // ------------------------

        // Validate the Rajshahi delivery details
        $request->validate([
            'phone_number' => 'required|string|max:15',
            'shipping_address' => 'required|string|max:500'
        ]);

        // Calculate final total
        $total = 0;
        foreach($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // 1. Create the Order
        $order = Order::create([
            'user_id' => Auth::id(),
            'phone_number' => $request->phone_number,
            'shipping_address' => $request->shipping_address,
            'total_amount' => $total,
        ]);

        // 2. Create the Order Items
        foreach($cart as $id => $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        // 3. Clear the session cart
        session()->forget('cart');

        return redirect()->route('dashboard')->with('success', 'Order placed successfully! We will deliver soon.');
    }
}