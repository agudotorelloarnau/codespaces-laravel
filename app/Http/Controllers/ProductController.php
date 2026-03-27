<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Product::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        if ($request->filled('category_name')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', $request->query('category_name'));
            });
        }

        return response()->json(['products' => $query->get()], 200);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $product = Product::with('category')->find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product], 200);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'size' => 'nullable|string|max:100',
            'color' => 'required|string|max:100',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $product = Product::create($validated);

        return response()->json(['product' => $product->load('category')], 201);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
            'size' => 'nullable|string|max:100',
            'color' => 'sometimes|required|string|max:100',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
        ]);

        $product->update($validated);

        return response()->json(['product' => $product->load('category')], 200);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        $product = Product::find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
