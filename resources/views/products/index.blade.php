@extends('layouts.admin')

@section('title','Manajemen Produk')

@section('content')

<div class="row mb-4">
    <div class="col d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Manajemen Produk</h4>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            + Tambah Produk
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th class="text-center" style="width:160px">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $product->name }}</div>
                                <small class="text-muted">{{ $product->slug }}</small>
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $product->category->name }}
                                </span>
                            </td>

                            <td>
                                Rp {{ number_format($product->base_price, 0, ',', '.') }}
                            </td>

                            <td>
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('products.edit', $product) }}"
                                   class="btn btn-sm btn-warning me-1">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin hapus produk ini?')"
                                            class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Belum ada produk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    @if($products->hasPages())
        <div class="card-footer bg-white">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection
