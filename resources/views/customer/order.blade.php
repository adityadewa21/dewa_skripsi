@extends('layouts.index')

@section('title','Pesanan Saya')

@section('content')
<div class="container py-5" style="max-width:900px">

    <h4 class="mb-4">Pesanan Saya</h4>

    @forelse ($orders as $order)
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <strong>{{ $order->order_code }}</strong><br>
                    <small>Status: {{ ucfirst($order->status) }}</small>
                </div>
                <div>
                    <a href="{{ route('customer.detailOrder', $order) }}" class="btn btn-sm btn-dark">
                        Detail
                    </a>
                </div>
            </div>
        </div>
    @empty
        <p>Belum ada pesanan.</p>
    @endforelse

</div>
@endsection
