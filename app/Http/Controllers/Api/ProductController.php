<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
{
    $products = Product::with(['store', 'detail'])
        ->latest()
        ->get()
        ->map(function ($product) {
            $product->image = $product->image
                ? asset('storage/' . $product->image)
                : null;

            return $product;
        });

    return response()->json($products);
}

    public function show($id)
    {
        $product = Product::with(['store', 'detail'])
            ->findOrFail($id);

        return response()->json($product);
    }
}