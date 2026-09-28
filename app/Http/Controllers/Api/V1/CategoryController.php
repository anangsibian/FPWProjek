<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     *
     * @response 200 {"data": [...]}
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Menyimpan kategori baru.
     *
     * @response 201 {"data": {...}}
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $category = Category::create($validated);

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Menampilkan detail satu kategori.
     *
     * @response 200 {"data": {...}}
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Memperbarui kategori.
     *
     * @response 200 {"data": {...}}
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
        ]);

        $category->update($validated);

        return new CategoryResource($category);
    }

    /**
     * Menghapus kategori.
     *
     * @response 204 {}
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
