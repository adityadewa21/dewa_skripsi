@extends('layouts.index')

@section('title','Detail Pesanan')

@section('content')
<section class="py-5">
    <div class="container" style="max-width:900px">

        <a href="{{ route('customer.order') }}" class="text-decoration-none mb-3 d-inline-block">
            ← Kembali ke Pesanan Saya
        </a>

        <div class="card shadow-sm">
            <div class="card-body">

                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="mb-1">Order {{ $order->order_code }}</h5>
                        <small class="text-muted">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </small>
                    </div>

                    <span class="badge
                        @if($order->status === 'menunggu konfirmasi') bg-warning
                        @elseif($order->status === 'diproses') bg-info
                        @elseif($order->status === 'dalam pengiriman') bg-primary
                        @elseif($order->status === 'selesai') bg-success
                        @else bg-secondary
                        @endif
                    ">
                        {{ strtoupper($order->status) }}
                    </span>
                </div>

                {{-- CUSTOMER --}}
                <h6 class="mb-2">Data Pengiriman</h6>
                <div class="mb-4">
                    <div><strong>Nama:</strong> {{ $order->customer_name }}</div>
                    <div><strong>WhatsApp:</strong> {{ $order->customer_phone }}</div>
                    <div><strong>Alamat:</strong> {{ $order->customer_address }}</div>
                </div>

                <hr>

                {{-- ITEMS --}}
                <h6 class="mb-3">Detail Produk</h6>

                @foreach($order->orderItems as $item)
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <strong>{{ $item->product_name }}</strong><br>
                            <small class="text-muted">
                                Varian: {{ $item->color_name }}
                            </small>
                        </div>

                        <div class="text-end">
                            <div>x {{ $item->quantity }}</div>
                            <div>
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @endforeach

                <hr>

                {{-- TOTAL --}}
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total Pembayaran</span>
                    <span>
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                </div>

                {{-- ACTION --}}
                @if($order->status === 'pending')
                    <a href="https://wa.me/6285172116048?text={{ $order->whatsapp_message }}"
                       target="_blank"
                       class="btn btn-dark w-100 mt-4">
                        Konfirmasi Pembayaran via WhatsApp
                    </a>
                @endif

            </div>
        </div>

    </div>
</section>
@endsection
