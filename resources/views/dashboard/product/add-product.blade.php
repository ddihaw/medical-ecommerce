@extends('layout.main')
@section('title', 'Tambah Produk')
@section('breadcrumb-title', 'Tambah Produk')
@section('breadcrumb-links')
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Tambah Produk</li>
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
                        <h6 class="text-capitalize mb-0"><i class="ni ni-box-2 text-primary me-2"></i> Tambah Produk
                        </h6>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="ni ni-bold-left"></i> Kembali
                        </a>
                    </div>
                    <hr class="horizontal dark mt-3 mb-0">
                </div>

                <div class="card-body p-3">
                    <form action="{{ route('products.new') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label text-sm">Nama Produk</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama produk"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-sm">Deskripsi</label>
                            <textarea name="description" id="description"
                                class="form-control @error('description') is-invalid @enderror" rows="5"
                                placeholder="Masukkan deskripsi lengkap produk">{{ old('description') }}</textarea>
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
                                        placeholder="Contoh: 50000" value="{{ old('price') }}" min="0" required>
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
                                        value="{{ old('stock') }}" min="0" step="1" required>
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
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if (old('category_id') == $category->id) selected @endif>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="primary_image" class="form-label text-sm">Gambar Utama (Wajib)</label>
                            <input type="file" name="primary_image" id="primary_image"
                                class="form-control @error('primary_image') is-invalid @enderror" required
                                accept="image/png, image/jpeg, image/webp">
                            <small class="text-muted">Gambar ini akan menjadi cover produk.</small>
                            @error('primary_image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label text-sm">Gambar Tambahan (Opsional)</label>
                            <input type="file" name="images[]" id="images"
                                class="form-control @error('images') is-invalid @enderror" multiple
                                accept="image/png, image/jpeg, image/webp">
                            <small class="text-muted">Anda bisa meng-upload lebih dari satu gambar tambahan.</small>
                            @error('images')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            @error('images.*')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn bg-gradient-primary mb-0">
                                <i class="ni ni-check-bold me-1"></i> Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-muted text-xs text-center py-2">
                    <i class="ni ni-archive-2 text-primary"></i> Data produk akan otomatis tersimpan di database.
                </div>
            </div>
        </div>
    </div>
@endsection