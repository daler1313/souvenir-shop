<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users with their orders.
     */
    public function index()
    {
        return User::with('orders')->get(); // Get all users with their orders
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $validated['password'] = bcrypt($validated['password']); // Hash the password

        $user = User::create($validated); // Create the user with validated data

        return response()->json($user, 201); // Return the created user with 201 status
    }

    /**
     * Display the specified user with their orders.
     */
    public function show($id)
    {
        return User::with('orders')->findOrFail($id); // Find user by ID and include their orders
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']); // Hash password if provided
        }

        $user = User::findOrFail($id); // Find user by ID or fail
        $user->update($validated); // Update the user with the validated data

        return response()->json($user); // Return the updated user
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Find the user by ID or fail
        $user->delete(); // Delete the user

        return response()->json(null, 204); // Return no content status on successful deletion
    }
}
