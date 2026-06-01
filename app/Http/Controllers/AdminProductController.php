<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; 
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        $imageName = time() . '.' . $request->image->extension();  
        $request->image->move(public_path('images'), $imageName); 
        
        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => 'images/' . $imageName, 
        ]);

        return redirect()->route('admin.products.index')->with('success', 'New product added successfully!');
    }

    // ==========================================
    // NEW: Show the Edit Form
    // ==========================================
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // ==========================================
    // NEW: Process the Update
    // ==========================================
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            // Image is nullable here because a new image might not be uploaded during an update
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        $product = Product::findOrFail($id);

        // Check if a new image was uploaded
        if ($request->hasFile('image')) {
            
            // Delete the old image from the server
            if(File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            // Upload the new image
            $imageName = time() . '.' . $request->image->extension();  
            $request->image->move(public_path('images'), $imageName); 
            $product->image = 'images/' . $imageName; // Update the path in the database
        }

        // Update the rest of the text fields
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if(File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}