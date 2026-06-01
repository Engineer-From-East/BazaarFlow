<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; // Required to fetch categories
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
        // Fetch all categories to send to the dropdown
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate the category_id along with the rest of the data
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
            'category_id' => $request->category_id, // Save the selected category
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => 'images/' . $imageName, 
        ]);

        return redirect()->route('admin.products.index')->with('success', 'New product added successfully!');
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