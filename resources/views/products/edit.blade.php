@extends('layouts.admin')

@section('title','Edit Produk')

@section('content')

{{-- ================= PRODUCT FORM ================= --}}
<div class="card shadow-sm mb-4">
    <div class="card-header">
        <h5 class="mb-0">Edit Produk</h5>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('products.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Kategori</label>
                <select name="category_id" class="form-select" required>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"
                            @selected($product->category_id == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Produk</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name',$product->name) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description"
                          class="form-control"
                          rows="4">{{ old('description',$product->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Harga Dasar</label>
                <input type="number"
                       name="base_price"
                       class="form-control"
                       value="{{ old('base_price',$product->base_price) }}">
                <small class="text-muted">
                    Bisa dikosongkan jika harga dari varian
                </small>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="is_active" class="form-select">
                    <option value="1" @selected($product->is_active)>Aktif</option>
                    <option value="0" @selected(!$product->is_active)>Nonaktif</option>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('products') }}" class="btn btn-secondary">
                    Kembali
                </a>
                <button class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= VARIANT LIST ================= --}}
<div class="card">
<div class="card-body">

<h5 class="mb-3">Varian Produk</h5>

<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th>Warna</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Status</th>
            <th>PO (Hari)</th>
            <th width="170">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($product->variants as $variant)
        <tr>
            {{-- UPDATE VARIANT --}}
            <form method="POST"
                  action="{{ route('product-variants.update',$variant) }}">
                @csrf
                @method('PUT')

                <td>
                    <input type="text" name="color_name"
                           class="form-control"
                           value="{{ $variant->color_name }}" required>
                </td>

                <td>
                    <input type="number" name="price"
                           class="form-control"
                           value="{{ $variant->price }}" required>
                </td>

                <td>
                    <input type="number" name="stock"
                           class="form-control"
                           value="{{ $variant->stock }}" required>
                </td>

                <td>
                    <select name="status" class="form-select">
                        <option value="ready" @selected($variant->status=='ready')>
                            Ready
                        </option>
                        <option value="preorder" @selected($variant->status=='preorder')>
                            Preorder
                        </option>
                    </select>
                </td>

                <td>
                    <input type="number"
                           name="po_estimation_days"
                           class="form-control"
                           value="{{ $variant->po_estimation_days }}">
                </td>

                <td class="text-center">
                    <button class="btn btn-sm btn-success mb-1 w-100">
                        Simpan
                    </button>
            </form>

            {{-- DELETE VARIANT --}}
            <form method="POST"
                  action="{{ route('product-variants.destroy',$variant) }}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Hapus varian?')"
                        class="btn btn-sm btn-danger w-100">
                    Hapus
                </button>
            </form>
                </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">
                Belum ada varian
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<hr>

{{-- ADD VARIANT --}}
<h6 class="mb-3">Tambah Varian</h6>

<form method="POST" action="{{ route('product-variants.store') }}">
@csrf
<input type="hidden" name="product_id" value="{{ $product->id }}">

<div class="row g-2">
    <div class="col-md-3">
        <input type="text" name="color_name"
               class="form-control" placeholder="Warna" required>
    </div>
    <div class="col-md-2">
        <input type="number" name="price"
               class="form-control" placeholder="Harga" required>
    </div>
    <div class="col-md-2">
        <input type="number" name="stock"
               class="form-control" placeholder="Stok" required>
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="ready">Ready</option>
            <option value="preorder">Preorder</option>
        </select>
    </div>
    <div class="col-md-2">
        <input type="number" name="po_estimation_days"
               class="form-control" placeholder="PO (hari)">
    </div>
    <div class="col-md-1 d-grid">
        <button class="btn btn-primary">+</button>
    </div>
</div>
</form>

</div>
</div>

{{-- ================= PRODUCT IMAGES ================= --}}
<div class="card mt-4">
<div class="card-body">

<h5 class="mb-3">Gambar Produk</h5>

{{-- Upload --}}
<form method="POST"
      action="{{ route('product-images.store') }}"
      enctype="multipart/form-data"
      class="mb-4">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="row g-2 align-items-end">
        <div class="col-md-10">
            <input type="file"
                   name="images[]"
                   class="form-control"
                   multiple
                   required>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-primary">
                Upload
            </button>
        </div>
    </div>
</form>

{{-- Image List --}}
<div class="row g-3">
@forelse($product->images as $image)
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <img src="{{ asset('storage/'.$image->image_path) }}"
                 class="card-img-top"
                 style="height:180px;object-fit:cover">

            <div class="card-body text-center">

                @if($image->is_primary)
                    <span class="badge bg-success mb-2">
                        Gambar Utama
                    </span>
                @else
                    <form method="POST"
                          action="{{ route('product-images.primary',$image) }}">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-sm btn-outline-success mb-2">
                            Jadikan Utama
                        </button>
                    </form>
                @endif

                <form method="POST"
                      action="{{ route('product-images.destroy',$image) }}">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Hapus gambar?')"
                            class="btn btn-sm btn-danger w-100">
                        Hapus
                    </button>
                </form>

            </div>
        </div>
    </div>
@empty
    <div class="col-12 text-center text-muted">
        Belum ada gambar
    </div>
@endforelse
</div>

</div>
</div>

@endsection
