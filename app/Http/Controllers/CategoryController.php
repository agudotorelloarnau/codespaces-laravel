<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $categories = Category::with('products')->get();

        return response()->json(['categories' => $categories], 200);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $category = Category::with('products')->find($id);

        if (! $category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json(['category' => $category], 200);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $category = Category::create($validated);

        return response()->json(['category' => $category], 201);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
        ]);

        $category->update($validated);

        return response()->json(['category' => $category], 200);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $category = Category::find($id);

        if (! $category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->products()->update(['category_id' => null]);
        $category->delete();

        return response()->json(['message' => 'Category deleted'], 200);
    }
}
