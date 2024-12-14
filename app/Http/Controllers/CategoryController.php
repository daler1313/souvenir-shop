<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::with('products')->get();
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);
    
        $category = Category::create($validated);
    
        return response()->json($category, 201);
    }
    
    public function show($id)
    {
        return Category::with('products')->findOrFail($id);
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
        ]);
    
        $category = Category::findOrFail($id);
        $category->update($validated);
    
        return response()->json($category);
    }
    
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    
        return response()->json(null, 204);
    }
}
