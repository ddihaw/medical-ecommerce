@extends('layout.main')
@section('title', 'Daftar Produk')
@section('breadcrumb-title', 'Daftar Produk')
@section('breadcrumb-links')
    <li class="breadcrumb-item text-sm text-white active" aria-current="page">Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if (session()->has('message'))
                <div class="alert alert-{{ session('message')[0] }} alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white"><strong>{{ session('message')[1] }}</strong></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Daftar Produk</h6>
                    <div>
                        <a href="{{ route('products.add') }}" class="btn btn-sm btn-primary me-2">
                            <i class="fa fa-plus"></i> Tambah Produk
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-file-pdf"></i> Simpan ke PDF
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">
                                        Produk
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Harga
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Stok
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Toko
                                    </th>
                                    <th class="text-secondary opacity-7 text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    @if ($product->primaryImage)
                                                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}"
                                                            class="avatar avatar-sm me-3" alt="product image">
                                                    @else
                                                        <div
                                                            class="avatar avatar-sm me-3 d-flex align-items-center justify-content-center bg-light">
                                                            <i class="fa fa-image text-secondary"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </p>
                                        </td>

                                        <td class="align-middle text-center text-sm">
                                            @if ($product->stock < 10)
                                                <span class="badge badge-sm bg-gradient-warning">{{ $product->stock }}</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-success">{{ $product->stock }}</span>
                                            @endif
                                        </td>

                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $product->store->store_name ?? 'N/A' }}
                                            </span>
                                        </td>

                                        <td class="align-middle text-center">
                                            <a href="{{ route('products.edit', $product->id) }}" class="text-secondary font-weight-bold text-xs me-2"
                                                data-toggle="tooltip" data-original-title="Edit produk">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <p class="mb-0 text-secondary">Belum ada produk.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Link Pagination --}}
                    <div class="card-footer d-flex justify-content-end pb-0">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection