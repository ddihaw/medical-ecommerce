<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Str;
use Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        //return response()->json($categories, 200);
        return view('dashboard.category', compact('categories'));
    }

    public function show(Category $category)
    {
        $category->load('products');

        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'nullable|string|max:255|unique:categories',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only('name');

        // Jika slug tidak diisi, model kita (dari file sebelumnya)
        // akan otomatis membuatnya dari 'name'
        if ($request->filled('slug')) {
            $data['slug'] = $request->slug;
        }

        $category = Category::create($data);

        return response()->json([
            'message' => 'Kategori berhasil dibuat',
            'category' => $category,
        ], 201);
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            // 'unique' di-ignore untuk ID kategori ini
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,'.$category->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only('name');

        // Jika slug diisi, update. Jika dikosongkan, biarkan model
        // membuatnya dari 'name' (jika logic di modelnya di-setting begitu)
        if ($request->filled('slug')) {
            $data['slug'] = $request->slug;
        } else {
            // Hasilkan slug baru jika nama berubah dan slug dikosongkan
            if ($request->name !== $category->name) {
                $data['slug'] = Str::slug($request->name);
            }
        }

        $category->update($data);

        return response()->json([
            'message' => 'Kategori berhasil diperbarui',
            'category' => $category,
        ], 200);
    }

    public function destroy(Category $category)
    {
        // Opsi: Cek dulu apakah ada produk di kategori ini?
        if ($category->products()->count() > 0) {
            return response()->json(['message' => 'Tidak bisa hapus, kategori masih memiliki produk.'], 409);
        };

        $category->delete();

        return response()->json(['message' => 'Kategori berhasil dihapus'], 200);
    }
}
