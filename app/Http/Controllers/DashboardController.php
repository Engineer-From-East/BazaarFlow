<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // If the logged-in user is an Admin, fetch ALL orders
        if ($user->is_admin == 1) {
            $orders = Order::orderBy('created_at', 'desc')->get();
        } 
        // If it is a regular customer, fetch ONLY their specific orders
        else {
            $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }

        // Send those orders to the dashboard view
        return view('dashboard', compact('orders'));
    }
}