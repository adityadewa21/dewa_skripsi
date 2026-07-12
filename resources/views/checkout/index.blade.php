@extends('layouts.index')

@section('title','Checkout')

@section('content')
<section class="py-5">
    <div class="container" style="max-width:900px">

        <h3 class="mb-4">Checkout</h3>

        <div class="row g-4">

            {{-- LEFT : FORM --}}
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="mb-3">Data Pengiriman</h5>

                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                            <input type="hidden" name="quantity" value="{{ $qty }}">

                            <div class="mb-3">
                                <label>Nama Lengkap</label>
                                <input type="text" name="customer_name"
                                    class="form-control"
                                    value="{{ $customer['name'] }}" required>
                            </div>

                            <div class="mb-3">
                                <label>No WhatsApp</label>
                                <input type="text" name="customer_phone"
                                    class="form-control"
                                    value="{{ $customer['phone'] }}" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email"
                                    class="form-control"
                                    value="{{ $customer['email'] }}">
                            </div>

                            <div class="mb-3">
                                <label>Alamat Lengkap</label>
                                <textarea name="customer_address"
                                        class="form-control"
                                        rows="4" required>{{ $customer['address'] }}</textarea>
                            </div>

                            <button class="btn btn-dark w-100">
                                Buat Pesanan
                            </button>
                        </form>
                        @auth
                            <small class="text-muted d-block mt-3">
                                Pastikan data pesanan sudah sesuai.
                            </small>
                        @endauth

                    </div>
                </div>
            </div>

            {{-- RIGHT : ORDER SUMMARY --}}
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <h5 class="mb-3">Ringkasan Pesanan</h5>

                        <div class="d-flex justify-content-between">
                            <span>{{ $product->name }}</span>
                            <span>x {{ $qty }}</span>
                        </div>

                        <small class="text-muted">
                            Varian: {{ $variant->color_name }}
                        </small>

                        <hr>

                        <div class="d-flex justify-content-between fw-semibold">
                            <span>Total</span>
                            <span>
                                Rp {{ number_format($variant->price * $qty, 0, ',', '.') }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
