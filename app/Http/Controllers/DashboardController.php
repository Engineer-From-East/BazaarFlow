<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product; // Added to count products
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Check if the logged-in user is an admin
        if (Auth::user()->is_admin) {
            
            // Get all orders for the table
            $orders = Order::with('items.product')->latest()->get();
            
            // CALCULATE BUSINESS METRICS
            $pendingOrders = Order::where('status', 'pending')->count();
            // Sum the total amounts of ONLY the completed orders
            $totalSales = Order::where('status', 'completed')->sum('total_amount');
            $totalProducts = Product::count();

            // Send orders AND metrics to the dashboard
            return view('dashboard', compact('orders', 'pendingOrders', 'totalSales', 'totalProducts'));
            
        } else {
            // 2. If it is a normal customer, only show their specific orders
            $orders = Order::with('items.product')
                           ->where('user_id', Auth::id())
                           ->latest()
                           ->get();
                           
            return view('dashboard', compact('orders'));
        }
    }
}