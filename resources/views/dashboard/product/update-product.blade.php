@extends('layout.main')
@section('title', 'Edit Produk')
@section('breadcrumb-title', 'Edit Produk')
@section('breadcrumb-links')
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Edit Produk</li>
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-lg-12 mb-lg-0 mb-4">
            @if (session()->has('message'))
                <div class="alert alert-{{ session('message')[0] }} alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white"><strong>{{ session('message')[1] }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">
                        <strong>Gagal!</strong> Ada beberapa kesalahan input yang perlu diperbaiki.
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow-lg border-0">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-capitalize mb-0"><i class="ni ni-box-2 text-primary me-2"></i> Edit Produk
                        </h6>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="ni ni-bold-left"></i> Kembali
                        </a>
                    </div>
                    <hr class="horizontal dark mt-3 mb-0">
                </div>

                <div class="card-body p-3">

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                        id="update-product-form">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label text-sm">Nama Produk</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama produk"
                                value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-sm">Deskripsi</label>
                            <textarea name="description" id="description"
                                class="form-control @error('description') is-invalid @enderror" rows="5"
                                placeholder="Masukkan deskripsi lengkap produk"
                                required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label text-sm">Harga (Rp)</label>
                                    <input type="number" name="price" id="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Contoh: 50000" value="{{ old('price', $product->price) }}" min="0"
                                        required>
                                    @error('price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label text-sm">Stok</label>
                                    <input type="number" name="stock" id="stock"
                                        class="form-control @error('stock') is-invalid @enderror" placeholder="Contoh: 100"
                                        value="{{ old('stock', $product->stock) }}" min="0" step="1" required>
                                    @error('stock')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label text-sm">Kategori (Wajib)</label>
                            <select name="category_id" id="category"
                                class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if (old('category_id', $product->category_id) == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr class="horizontal dark my-4">

                        <div class="mb-3">
                            <label class="form-label text-sm">Gambar Utama Saat Ini</label>
                            <div>
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="Primary Image"
                                        class="img-thumbnail" style="max-height: 150px;">
                                @else
                                    <span class="text-muted">Tidak ada gambar utama.</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="primary_image" class="form-label text-sm">Ganti Gambar Utama (Opsional)</label>
                            <input type="file" name="primary_image" id="primary_image"
                                class="form-control @error('primary_image') is-invalid @enderror"
                                accept="image/png, image/jpeg, image/webp">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar utama.</small>
                            @error('primary_image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label text-sm">Tambah Gambar Tambahan (Opsional)</label>
                            <input type="file" name="images[]" id="images"
                                class="form-control @error('images') is-invalid @enderror" multiple
                                accept="image/png, image/jpeg, image/webp">
                            @error('images')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @error('images.*')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>

                    <hr class="horizontal dark my-4">

                    <div class="mb-3">
                        <label class="form-label text-sm">Gambar Tambahan Saat Ini</label>
                        <div class="d-flex flex-wrap align-items-start">
                            @forelse ($product->images->where('is_primary', false) as $image)
                                <div class="me-3 mb-2"
                                    style="display: inline-flex; flex-direction: column; align-items: center; gap: 0.5rem;">

                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Extra Image"
                                        class="img-thumbnail" style="max-height: 100px;">

                                    <form
                                        action="{{ route('products.images.destroy', ['product' => $product->id, 'image' => $image->id]) }}"
                                        method="POST" class="form-delete" data-type="Gambar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-0">
                                            <i class="ni ni-basket me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <span class="text-muted">Tidak ada gambar tambahan.</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="form-delete"
                            data-type="Produk">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm bg-gradient-danger mb-0">
                                <i class="ni ni-basket me-1"></i> Hapus Produk
                            </button>
                        </form>

                        <button type="submit" class="btn btn-sm bg-gradient-primary mb-0 ms-2" form="update-product-form">
                            <i class="ni ni-check-bold me-1"></i> Update Produk
                        </button>
                    </div>

                </div>

                <div class="card-footer text-muted text-xs text-center py-2">
                    <i class="ni ni-archive-2 text-primary"></i> Perubahan produk akan otomatis tersimpan di database.
                </div>
            </div>
        </div>
    </div>
@endsection