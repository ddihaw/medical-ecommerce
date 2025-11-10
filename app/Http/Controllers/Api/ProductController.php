<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $storeId = Auth::user()->store?->id;

        $products = Product::query()
            ->where('store_id', $storeId)
            ->with(['store:id,store_name', 'category:id,name', 'primaryImage'])
            ->latest()
            ->paginate(15);

        return view('dashboard.product.product', compact('products'));
    }

    public function addProductForm()
    {
        $categories = Category::orderBy('id', 'asc')->get();

        return view('dashboard.product.add-product', compact('categories'));
    }

    public function updateProductForm(Product $product)
    {
        $categories = Category::orderBy('id', 'asc')->get();

        return view('dashboard.product.update-product', compact('product', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['store.user:id,name', 'categories', 'images']);

        return response()->json($product, 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (! $user->isSeller()) {
            return response()->json(['message' => 'Akses ditolak. Hanya untuk Seller.'], 403);
        }

        $store = $user->store;
        if (! $store) {
            return response()->json(['message' => 'Anda harus memiliki toko untuk membuat produk.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',

            'category_id' => 'required|exists:categories,id',

            'primary_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with(['message' => ['danger', 'Validasi gagal. Silakan periksa input Anda.']]);
        }

        $product = $store->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('primary_image')) {
            $path = $request->file('primary_image')->store('products', 'public');

            $product->images()->create([
                'image_path' => $path,
                'is_primary' => true,
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('products.index')->with('message', ['success', 'Produk berhasil dibuat']);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',

            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $product->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'category_id' => $validatedData['category_id'],
        ]);

        if ($request->hasFile('primary_image')) {

            $oldImage = $product->primaryImage;

            $path = $request->file('primary_image')->store('products', 'public');

            $product->images()->updateOrCreate(
                ['is_primary' => true],
                ['image_path' => $path]
            );

            if ($oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('products.edit', $product->id)
            ->with('message', ['success', 'Produk berhasil diperbarui!']);
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        $this->authorize('update', $product);

        if ($image->is_primary) {
            return redirect()->back()
                ->with('message', ['danger', 'Tidak dapat menghapus gambar utama.']);
        }

        Storage::disk('public')->delete($image->image_path);

        $image->delete();

        return redirect()->back()
            ->with('message', ['success', 'Gambar tambahan berhasil dihapus.']);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $imagePaths = $product->images()->pluck('image_path')->all();

        $product->delete();

        if (! empty($imagePaths)) {
            Storage::disk('public')->delete($imagePaths);
        }

        return redirect()->route('products.index')
            ->with('message', ['success', 'Produk berhasil dihapus.']);
    }
}
