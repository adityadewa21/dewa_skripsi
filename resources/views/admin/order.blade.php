@extends('layouts.admin')

@section('title','Admin - Orders')

@section('content')
<section class="py-5">
    <div class="container">

        <h3 class="mb-4">Daftar Pesanan</h3>

        <div class="card shadow-sm">
            <div class="card-body p-0">

                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>
                                    Rp {{ number_format($order->total_price,0,',','.') }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="btn btn-sm btn-outline-dark">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>

    </div>
</section>
@endsection
