@extends('layouts.admin')

@section('title','Tambah Produk')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Tambah Produk</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf

            {{-- Category --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            @selected(old('category_id') == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Product Name --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name') }}"
                       placeholder="Masukkan nama produk"
                       required>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description"
                          class="form-control"
                          rows="4"
                          placeholder="Deskripsi produk (opsional)">{{ old('description') }}</textarea>
            </div>

            {{-- Base Price --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Harga Dasar</label>
                <input type="number"
                       name="base_price"
                       class="form-control"
                       value="{{ old('base_price', 0) }}"
                       min="0"
                       step="0.01">
                <small class="text-muted">
                    Harga awal sebelum varian (boleh dikosongkan jika pakai varian)
                </small>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Status Produk</label>
                <select name="is_active" class="form-select">
                    <option value="1" @selected(old('is_active',1)==1)>Aktif</option>
                    <option value="0" @selected(old('is_active',1)==0)>Nonaktif</option>
                </select>
            </div>

            {{-- Action --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('products') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
