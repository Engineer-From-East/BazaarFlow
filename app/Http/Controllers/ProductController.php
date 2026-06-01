<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category; 

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 1. Fetch all categories to display in the sidebar
        $categories = Category::all();
        
        // 2. Start a database query for products
        $query = Product::query();

        // 3. Filter by Category (From Phase 12)
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            
            if ($category) {
                // Only get products that belong to this category
                $query->where('category_id', $category->id);
            }
        }

        // ==========================================
        // 4. NEW: Filter by Search Keyword (Phase 13)
        // ==========================================
        if ($request->has('search')) {
            $searchTerm = $request->search;
            // Search inside the product name OR the description
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
            });
        }

        // 5. Execute the query and get the final list of products
        $products = $query->latest()->get();

        // 6. Send both products and categories to the view
        return view('shop.index', compact('products', 'categories'));
    }
}