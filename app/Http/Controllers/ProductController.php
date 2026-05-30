<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        // Fetch all products and include their associated categories
        $products = Product::with('category')->latest()->get();
        
        // Send the products to the visual Blade file
        return view('shop.index', compact('products'));
    }
}