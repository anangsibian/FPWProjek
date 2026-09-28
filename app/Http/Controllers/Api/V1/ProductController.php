<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     *
     * @response 200 {"data": [...]}
     */
    public function index()
    {
        return ProductResource::collection(Product::with('category')->get());
    }

    /**
     * Menyimpan data produk baru.
     *
     * @response 201 {"data": {...}}
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'code' => ['required', 'string', 'max:50', 'unique:products,code'],
            'name' => ['required', 'string', 'max:255'],
            'unit' => ['nullable', 'string', 'max:20'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'string'],
        ]);

        $product = Product::create($validated);

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Menampilkan detail satu produk berdasarkan ID.
     *
     * @response 200 {"data": {...}}
     */
    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }

    /**
     * Memperbarui data produk.
     *
     * @response 200 {"data": {...}}
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => ['sometimes', 'exists:categories,id'],
            'code' => ['sometimes', 'string', 'max:50', 'unique:products,code,' . $product->id],
            'name' => ['sometimes', 'string', 'max:255'],
            'unit' => ['sometimes', 'nullable', 'string', 'max:20'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'stock' => ['sometimes', 'integer', 'min:0'],
            'image' => ['sometimes', 'nullable', 'string'],
        ]);

        $product->update($validated);

        return new ProductResource($product);
    }

    /**
     * Menghapus data produk.
     *
     * @response 204 {}
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(null, 204);
    }
}
