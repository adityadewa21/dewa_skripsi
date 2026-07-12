@extends('layouts.admin')

@section('title','Detail Order')

@section('content')
<section class="py-5">
    <div class="container" style="max-width:900px">

        <a href="{{ route('orders.order') }}"
           class="btn btn-sm btn-outline-secondary mb-3">
            ← Kembali
        </a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">

                <h5 class="mb-3">Order {{ $order->order_code }}</h5>

                {{-- CUSTOMER --}}
                <h6>Customer</h6>
                <p>
                    <strong>{{ $order->customer_name }}</strong><br>
                    {{ $order->customer_phone }}<br>
                    {{ $order->customer_address }}
                </p>

                <hr>

                {{-- ITEMS --}}
                <h6>Produk</h6>

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

                {{-- UPDATE STATUS --}}
                <form action="{{ route('orders.update', $order) }}"
                      method="POST"
                      class="mt-4">
                    @csrf
                    @method('PATCH')

                    <label class="form-label fw-semibold">
                        Update Status Pesanan
                    </label>

                    <select name="status" class="form-select mb-3">
                        @foreach(['menunggu konfirmasi','diproses','dalam pengiriman','selesai'] as $status)
                            <option value="{{ $status }}"
                                @selected($order->status === $status)>
                                {{ strtoupper($status) }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-dark w-100">
                        Simpan Status
                    </button>
                </form>

                {{-- WA --}}
                @php
                    $waNumber = preg_replace('/[^0-9]/', '', $order->customer_phone);

                    // kalau diawali 0 → ganti 62
                    if (str_starts_with($waNumber, '0')) {
                        $waNumber = '62' . substr($waNumber, 1);
                    }
                @endphp
                @php
                    $message = urlencode(
                        "Halo {$order->customer_name},\n\n" .
                        "Kami dari *Dewa Shop Official* 👋\n\n" .
                        "Pesanan Anda dengan nomor *#{$order->order_code}* saat ini sedang *diproses*.\n\n" .
                        "Kami akan segera menginformasikan kembali setelah pesanan dikirim.\n\n" .
                        "Terima kasih sudah berbelanja 🤍"
                    );
                @endphp
                <a href="https://wa.me/{{ $order->whatsapp_number }}?text={{ $message }}"
                    target="_blank"
                    class="btn btn-success w-100 mt-3">
                        Kirim Pesan ke Customer
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
