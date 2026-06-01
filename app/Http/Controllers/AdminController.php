<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\User; // <-- NEW: Required to fetch the customers
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // 1. Show the form to add a new product
    public function create()
    {
        // Fetch all categories so we can display them in a dropdown menu
        $categories = Category::all(); 
        return view('admin.create_product', compact('categories'));
    }

    // 2. Process the form and save to the database
    public function store(Request $request)
    {
        // Validate the incoming data (Now including the image!)
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        // Handle the Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            // This automatically saves the file to storage/app/public/products 
            // and generates a unique, safe filename.
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Create the new product with the image path included
        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath, // Save the file path to the database
        ]);

        // Redirect back with a success message
        return redirect()->route('admin.product.create')->with('success', 'New product with image added to the Bazaar successfully!');
    }
    
    // 3. Update the status of an order
    public function updateOrderStatus(Request $request, $id)
    {
        // FIXED: Added 'completed' to the allowed validation list so your new dashboard works perfectly!
        $request->validate([
            'status' => 'required|string|in:pending,completed,shipped,delivered,canceled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('dashboard')->with('success', 'Order #' . $order->id . ' status updated to ' . ucfirst($order->status) . '.');
    }

    // ==========================================
    // 4. NEW: Fetch Customer Accounts
    // ==========================================
    public function customers()
    {
        // Fetch all users who are NOT admins
        $customers = User::where('is_admin', false)->latest()->get();
        
        return view('admin.customers', compact('customers'));
    }
}