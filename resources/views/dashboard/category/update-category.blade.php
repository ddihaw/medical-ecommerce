@extends('layout.main')
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
            <div class="card shadow-lg border-0">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="text-capitalize mb-0"><i class="ni ni-folder-17 text-primary me-2"></i> Edit Kategori
                        </h6>
                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="ni ni-bold-left"></i> Kembali
                        </a>
                    </div>
                    <hr class="horizontal dark mt-3 mb-0">
                </div>

                <div class="card-body p-3">

                    <form action="{{ route('categories.update', $category->id) }}" method="POST" id="update-category-form">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label text-sm">Nama Kategori</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama kategori" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                    <div class="d-flex justify-content-end mt-4">

                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="form-delete">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm bg-gradient-danger mb-0">
                                <i class="ni ni-basket me-1"></i> Delete
                            </button>
                        </form>

                        <button type="submit" class="btn btn-sm bg-gradient-primary mb-0 ms-2" form="update-category-form">
                            <i class="ni ni-check-bold me-1"></i> Update
                        </button>

                    </div>
                </div>

                <div class="card-footer text-muted text-xs text-center py-2">
                    <i class="ni ni-archive-2 text-primary"></i> Perubahan kategori akan otomatis tersimpan di database.
                </div>
            </div>
        </div>
    </div>
@endsection