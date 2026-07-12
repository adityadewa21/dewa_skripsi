@extends('layouts.index')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">

    <h2 class="mb-4">Checkout</h2>

    <div class="row">
        {{-- FORM --}}
        <div class="col-md-6">
            <form action="{{ route('checkout.cart.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text"
                        name="customer_name"
                        value="{{ $customer['name'] }}"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text"
                        name="customer_phone"
                        value="{{ $customer['phone'] }}"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="customer_address"
                            class="form-control"
                            required>{{ $customer['address'] }}</textarea>
                </div>

                <button class="btn btn-dark w-100">
                    Checkout Sekarang
                </button>
            </form>
        </div>

        {{-- SUMMARY --}}
        <div class="col-md-6">
            <h5>Ringkasan</h5>

            <ul class="list-group">
                @php $total = 0; @endphp

                @foreach($cart->items as $item)
                    @php $subtotal = $item->variant->price * $item->quantity; @endphp
                    @php $total += $subtotal; @endphp

                    <li class="list-group-item d-flex justify-content-between">
                        <div>
                            {{ $item->variant->product->name }}<br>
                            <small>{{ $item->variant->color_name }}</small>
                        </div>
                        <span>
                            {{ $item->quantity }} x Rp {{ number_format($item->variant->price,0,',','.') }}
                        </span>
                    </li>
                @endforeach

                <li class="list-group-item d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>Rp {{ number_format($total,0,',','.') }}</strong>
                </li>
            </ul>
        </div>
    </div>

</div>
@endsection
