@extends('layouts.index')

@section('title','Keranjang')

@section('content')
<section class="py-5">
<div class="container">

<h3 class="mb-4">🛒 Keranjang Belanja</h3>

@if($items->count())

<div class="table-responsive">
<table class="table align-middle">

<thead>
<tr>
    <th>Produk</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Subtotal</th>
    <th></th>
</tr>
</thead>

<tbody>
@foreach($items as $item)
<tr>

<td>
    <div class="d-flex align-items-center gap-3">
        <img src="{{ $item->variant->product->primaryImage
            ? asset('storage/'.$item->variant->product->primaryImage->image_path)
            : asset('template/images/placeholder.jpg') }}"
            width="70">

        <div>
            <div class="fw-semibold">
                {{ $item->variant->product->name }}
            </div>
            <small class="text-muted">
                {{ $item->variant->color_name }}
            </small>
        </div>
    </div>
</td>

<td>
    Rp {{ number_format($item->price,0,',','.') }}
</td>

<td>
    <form action="{{ route('cart.update', $item->id) }}" method="POST">
        @csrf
        <input type="number"
               name="quantity"
               value="{{ $item->quantity }}"
               min="1"
               class="form-control"
               style="width:80px"
               onchange="this.form.submit()">
    </form>
</td>

<td>
    Rp {{ number_format($item->price * $item->quantity,0,',','.') }}
</td>

<td>
    <form action="{{ route('cart.delete', $item->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">
            Hapus
        </button>
    </form>
</td>

</tr>
@endforeach
</tbody>

</table>
</div>

{{-- TOTAL --}}
<div class="d-flex justify-content-end mt-4">
    <div style="max-width:300px; width:100%">
        <div class="d-flex justify-content-between mb-2">
            <span>Total</span>
            <strong>Rp {{ number_format($total,0,',','.') }}</strong>
        </div>

        <a href="{{ route('checkout.cart') }}"
           class="btn btn-dark w-100">
            Checkout Semua
        </a>
    </div>
</div>

@else
<div class="text-center py-5">
    <h5>Keranjang masih kosong</h5>
    <a href="/" class="btn btn-outline-dark mt-3">
        Belanja Sekarang
    </a>
</div>
@endif

</div>
</section>
@endsection
