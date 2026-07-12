@extends('layouts.admin')

@section('title','Detail Analitik Produk')

@section('content')
<div class="row g-4">

    {{-- INFO --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>{{ $product->name }}</h5>

                <p class="mb-1">
                    <strong>Total View:</strong><br>
                    {{ $totalViews }}
                </p>

                <p class="mb-0">
                    <strong>Status:</strong>
                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                </p>
            </div>
        </div>
    </div>

    {{-- MONTHLY SALES --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h6>Penjualan Bulanan</h6>
            </div>

            <div class="card-body">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($product->monthlySales as $sale)
                        <tr>
                            <td>{{ $sale->month }}</td>
                            <td>{{ $sale->total_sold }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                Belum ada data penjualan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
