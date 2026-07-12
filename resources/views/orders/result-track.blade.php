@extends('layouts.index')

@section('title','Detail Tracking')

@section('content')
<section class="py-5">
    <div class="container" style="max-width:900px">

        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="mb-3">
                    Order {{ $order->order_code }}
                </h5>

                {{-- STATUS TIMELINE --}}
                <div class="row text-center mb-4">
                    @php
                        $statuses = ['menunggu konfirmasi','diproses','dalam pengiriman','selesai'];
                        $currentIndex = array_search($order->status, $statuses);
                    @endphp

                    @foreach($statuses as $index => $status)
                        <div class="col">
                            <div class="py-2 rounded
                                {{ $index <= $currentIndex ? 'bg-warning text-white' : 'bg-primary text-muted' }}">
                                <small class="fw-semibold">
                                    {{ strtoupper($status) }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- CUSTOMER --}}
                <h6>Data Pengiriman</h6>
                <p class="mb-3">
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->customer_phone }}<br>
                    {{ $order->customer_address }}
                </p>

                <hr>

                {{-- ITEMS --}}
                <h6>Detail Produk</h6>

                @foreach($order->orderItems as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            {{ $item->product_name }}<br>
                            <small class="text-muted">
                                {{ $item->color_name }}
                            </small>
                        </div>
                        <div>
                            x{{ $item->quantity }}
                        </div>
                    </div>
                @endforeach

                <hr>

                <div class="d-flex justify-content-between fw-bold">
                    <span>Total</span>
                    <span>
                        Rp {{ number_format($order->total_price,0,',','.') }}
                    </span>
                </div>

                {{-- ACTION --}}
                @if($order->status === 'pending')
                    <a href="https://wa.me/62XXXXXXXXXX?text={{ $order->whatsapp_message }}"
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
