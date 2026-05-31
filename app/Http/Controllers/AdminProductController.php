<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    // 1. READ: Display a list of all products
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    // 2. CREATE: Show the form to add a new product
    public function create()
    {
        return view('admin.products.create');
    }

    // 3. STORE: Save the new product and upload the image
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // 2MB Max
        ]);

        // Handle the Image Upload
        $imageName = time() . '.' . $request->image->extension();  
        $request->image->move(public_path('images'), $imageName); // Saves to public/images folder
        
        // Save to Database
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => 'images/' . $imageName, // Stores the path
        ]);

        return redirect()->route('admin.products.index')->with('success', 'New perfume added successfully!');
    }

    // 4. DELETE: Remove a product from the database
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete the image file from the server so it doesn't take up space
        if(File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}