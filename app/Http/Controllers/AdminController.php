<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str; // <-- Added this to generate slugs

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
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // Create the new product with the auto-generated slug
        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // <-- Generates URL-safe string
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        // Redirect back with a success message
        return redirect()->route('admin.product.create')->with('success', 'New product added to the Bazaar successfully!');
    }
}