@extends('layouts.index')

@section('title','Pesanan Berhasil')

@section('content')
<section class="py-5">
    <div class="container" style="max-width:800px">

        <div class="card shadow-sm">
            <div class="card-body text-center">

                <h3 class="text-success mb-3">Pesanan Berhasil Dibuat 🎉</h3>

                <p class="mb-1">Order ID</p>
                <h5 class="fw-bold">{{ $order->order_code }}</h5>

                <hr>

                <h6 class="mb-3">Detail Pesanan</h6>

                @foreach($order->orderItems as $item)
                    <p class="mb-1">
                        {{ $item->product_name }} ({{ $item->color_name }})<br>
                        {{ $item->quantity }} x Rp {{ number_format($item->price,0,',','.') }}
                    </p>
                @endforeach

                <hr>

                <h5>
                    Total Bayar:
                    <span class="text-danger">
                        Rp {{ number_format($order->total_price,0,',','.') }}
                    </span>
                </h5>
                <hr>

                <div class="mt-4">
                    <a href="https://wa.me/6289525309063?text={{ $order->whatsapp_message }}"
                       target="_blank"
                       class="btn btn-success px-4">
                        Konfirmasi via WhatsApp
                    </a>
                </div>

                <small class="text-muted d-block mt-3">
                    Kirim bukti transfer melalui WhatsApp agar pesanan segera diproses.
                </small>

            </div>
        </div>

    </div>
</section>
@endsection
