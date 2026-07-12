@extends('layouts.index')

@section('title', $product->name)

@section('content')
<section class="py-5">
    <div class="container">

        {{-- BREADCRUMB --}}
        <nav class="mb-4 small">
            <a href="/" class="text-muted text-decoration-none">Home</a> /
            <a href="{{ route('category.show', $product->category->slug) }}"
               class="text-muted text-decoration-none">
                {{ $product->category->name }}
            </a> /
            <span class="fw-semibold">{{ $product->name }}</span>
        </nav>

        <div class="row g-5">

            {{-- LEFT : IMAGES --}}
            <div class="col-md-6">

                {{-- PRIMARY IMAGE --}}
                <div class="mb-3 border rounded p-2">
                    <img
                        src="{{ $product->primaryImage
                            ? asset('storage/' . $product->primaryImage->image_path)
                            : asset('template/images/placeholder.jpg') }}"
                        class="img-fluid rounded w-100"
                        id="mainProductImage"
                        alt="{{ $product->name }}">
                </div>

                {{-- GALLERY --}}
                @if($product->images->count())
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($product->images as $image)
                        <img
                            src="{{ asset('storage/' . $image->image_path) }}"
                            class="img-thumbnail"
                            style="width:80px; cursor:pointer"
                            onclick="document.getElementById('mainProductImage').src=this.src">
                    @endforeach
                </div>
                @endif
            </div>

            {{-- RIGHT : INFO --}}
            <div class="col-md-6">

                <h2 class="mb-2">{{ $product->name }}</h2>

                <h4 class="text-danger fw-bold mb-3">
                    Rp {{ number_format($product->base_price, 0, ',', '.') }}
                </h4>

                <p class="text-muted">
                    {!! nl2br(e($product->description)) !!}
                </p>

                <hr>

                {{-- FORM CHECKOUT --}}
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf

                    {{-- VARIANT --}}
                    @if($product->variants->count())
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Pilih Varian
                            </label>
                            <select name="variant_id" class="form-select" required>
                                @foreach($product->variants as $variant)
                                    <option value="{{ $variant->id }}">
                                        {{ $variant->color_name }}
                                        — Rp {{ number_format($variant->price, 0, ',', '.') }}
                                        (stok {{ $variant->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- QTY --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Jumlah</label>
                        <input type="number"
                            name="qty"
                            class="form-control"
                            value="1"
                            min="1"
                            style="max-width:120px"
                            required>
                    </div>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    {{-- BUTTON --}}
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-dark px-4">
                            🛒 Masukkan Keranjang
                        </button>

                        <button type="submit"
                                formaction="{{ route('checkout.index', $product->slug) }}"
                                formmethod="GET"
                                class="btn btn-dark px-4">
                            Checkout Sekarang
                        </button>
                    </div>
                </form>

                {{-- INFO --}}
                <div class="mt-4 small text-muted">
                    ✔ Pembayaran via transfer (Total barang belum termasuk ongkir)<br>
                    ✔ Konfirmasi  via WhatsApp
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
