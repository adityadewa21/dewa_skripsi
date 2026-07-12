@extends('layouts.index')

@section('title', $category->name)

@section('content')
<section class="py-5 bg-light">
    <div class="container">

        {{-- HEADER CATEGORY --}}
        <div class="text-center mb-5">
            <h1 class="section-title">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-muted">{{ $category->description }}</p>
            @endif
        </div>

        {{-- PRODUCT LIST --}}
        <div class="row g-4">
            @forelse($products as $product)
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
                    <p class="text-muted">Produk belum tersedia di kategori ini.</p>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>

    </div>
</section>
@endsection
