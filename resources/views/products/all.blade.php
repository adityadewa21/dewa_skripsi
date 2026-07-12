@extends('layouts.index')

@section('title', 'Product')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">All Products</h2>
        </div>

        <div class="row g-4">
            @forelse($newArrivals as $product)
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product-item">
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img
                                src="{{ $product->primaryImage
                                    ? asset('storage/' . $product->primaryImage->image_path)
                                    : asset('template/images/placeholder.jpg') }}"
                                class="img-fluid rounded mb-2"
                                alt="{{ $product->name }}">
                        </a>

                        <h6 class="mt-2 mb-1">{{ $product->name }}</h6>

                        <span class="text-muted">
                            Rp {{ number_format($product->base_price, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Produk belum tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
