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
        $categories = Category::orderBy('id', 'asc')->get();

        return view('dashboard.category.category', compact('categories'));
    }

    public function show(Category $category)
    {
        $category->load('products');

        return response()->json($category, 200);
    }

    public function newCategoryForm()
    {
        return view('dashboard.category.add-category');
    }

    public function editCategoryForm(Category $category)
    {
        return view('dashboard.category.update-category', compact('category'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories',
            'slug' => 'nullable|string|max:255|unique:categories',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', ['danger', 'Gagal menambahkan kategori, silakan cek kembali inputan Anda.']);
        }

        $data = $request->only('name');

        if ($request->filled('slug')) {
            $data['slug'] = $request->slug;
        }

        $category = Category::create($data);

        return redirect(route('categories.index'))->with('message', ['info', 'Kategori berhasil ditambahkan.']);
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'slug' => 'nullable|string|max:255|unique:categories,slug,'.$category->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('message', ['danger', 'Gagal mengubah kategori, silakan cek kembali inputan Anda.']);
        }

        $data = $request->only('name');

        if ($request->filled('slug')) {
            $data['slug'] = $request->slug;
        } else {
            if ($request->name !== $category->name) {
                $data['slug'] = Str::slug($request->name);
            }
        }

        $category->update($data);

        return redirect(route('categories.index'))->with('message', ['info', 'Kategori berhasil diperbarui.']);
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->back()
                ->with('message', ['danger', 'Tidak bisa hapus, kategori masih memiliki produk.']);
        }

        $category->delete();

        return redirect(route('categories.index'))
            ->with('message', ['info', 'Kategori berhasil dihapus.']);
    }
}
