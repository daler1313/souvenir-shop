<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Order; // Corrected from App\Models\Order to use singular Order
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with(['user', 'product'])->get(); // Fetch orders with their associated user and product
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric',
        ]);

        $order = Order::create($validated); // Create the order with validated data

        return response()->json($order, 201); // Return the created order with status 201
    }

    public function show($id)
    {
        return Order::with(['user', 'product'])->findOrFail($id); // Fetch the specific order with its related user and product
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'exists:users,id', // Validation for existing user
            'product_id' => 'exists:products,id', // Validation for existing product
            'quantity' => 'integer|min:1', // Ensure valid quantity
            'total_price' => 'numeric', // Ensure valid total price
        ]);

        $order = Order::findOrFail($id); // Find the order by ID
        $order->update($validated); // Update the order with the validated data

        return response()->json($order); // Return the updated order
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id); // Find the order by ID
        $order->delete(); // Delete the order

        return response()->json(null, 204); // Return status 204 to indicate successful deletion
    }
}
