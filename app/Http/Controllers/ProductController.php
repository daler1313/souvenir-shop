<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Для работы с файловой системой

class ProductController extends Controller
{
    /**
     * Display a listing of the products with their categories.
     */
    public function index()
    {
        return Product::with('category')->get(); // Fetch products with associated categories
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Валидация входящих данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id', // Ensure category exists
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Параметры для изображения
        ]);

        // Сохранение изображения, если оно есть
        if ($request->hasFile('image_path')) {
            // Генерируем уникальное имя для изображения
            $imageName = time().'.'.$request->image_path->extension();
            // Сохраняем изображение в папку 'public/images' и получаем путь
            $request->image_path->storeAs('public/images', $imageName);
            // Добавляем путь изображения в массив данных
            $validated['image_path'] = $imageName;
        }

        // Создание продукта с валидацией
        $product = Product::create($validated);

        // Возвращаем созданный продукт с кодом статуса 201
        return response()->json($product, 201);
    }

    /**
     * Display the specified product with its category.
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id); // Fetch product with category by ID

        return response()->json($product); // Return the product with its category
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        // Валидация входящих данных
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255', // 'sometimes' means it's optional
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Параметры для изображения
        ]);

        $product = Product::findOrFail($id); // Находим продукт по ID или выдаем ошибку

        // Сохраняем изображение, если оно есть
        if ($request->hasFile('image_path')) {
            // Генерируем уникальное имя для изображения
            $imageName = time().'.'.$request->image_path->extension();
            // Сохраняем изображение в папку 'public/images' и получаем путь
            $request->image_path->storeAs('public/images', $imageName);
            // Добавляем путь изображения в массив данных
            $validated['image_path'] = $imageName;
        }

        // Обновляем продукт с валидацией
        $product->update($validated);

        return response()->json($product); // Возвращаем обновленный продукт
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id); // Находим продукт или выдаем ошибку
        // Удаляем изображение с сервера, если оно существует
        if ($product->image_path) {
            Storage::delete('public/images/'.$product->image_path);
        }
        $product->delete(); // Удаляем продукт

        return response()->json(null, 204); // Возвращаем статус 204 (без контента)
    }
}
