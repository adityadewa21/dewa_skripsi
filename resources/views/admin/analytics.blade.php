@extends('layouts.admin')

@section('title','Analytics')

@section('content')

<h4 class="mb-4">📊 Analytics Penjualan ({{ $currentMonth }})</h4>

<div class="row g-4 mb-4">

    {{-- PRODUK TERLARIS --}}
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">🏆 Produk Terlaris Bulan Ini</h6>

                @forelse($topProducts as $i => $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $i + 1 }}. {{ $item->product->name }}</span>
                        <span class="badge bg-dark">{{ $item->total_sold }}</span>
                    </div>
                @empty
                    <p class="text-muted">Belum ada penjualan</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- PRODUK PALING DILIHAT --}}
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">👁 Produk Paling Banyak Dilihat</h6>

                @forelse($topViewedProducts as $i => $product)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $i + 1 }}. {{ $product->name }}</span>
                        <span class="badge bg-secondary">
                            {{ $product->views_count }} views
                        </span>
                    </div>
                @empty
                    <p class="text-muted">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- RINGKASAN --}}
    <div class="col-lg-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">📌 Ringkasan</h6>

                <div class="mb-2">
                    <small class="text-muted">Total Produk</small>
                    <div class="fw-bold fs-5">{{ $totalProducts }}</div>
                </div>

                <div class="mb-2">
                    <small class="text-muted">Total Views</small>
                    <div class="fw-bold fs-5">{{ number_format($totalViews) }}</div>
                </div>

                <div>
                    <small class="text-muted">Order Bulan Ini</small>
                    <div class="fw-bold fs-5">{{ $totalOrders }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- GRAFIK --}}
<div class="row g-4">

    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">📈 Monthly Sales per Produk</h6>
                <canvas id="salesChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-3">👁 Product Views</h6>
                <canvas id="viewChart" height="220"></canvas>
            </div>
        </div>
    </div>

</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* SALES CHART */
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: @json($salesChart['labels']),
        datasets: @json($salesChart['datasets']),
    },
    options: {
        responsive: true
    }
});

/* VIEW CHART */
new Chart(document.getElementById('viewChart'), {
    type: 'bar',
    data: {
        labels: @json($viewChart['labels']),
        datasets: [{
            label: 'Total Views',
            data: @json($viewChart['data']),
            backgroundColor: '#64748b'
        }]
    },
    options: {
        responsive: true
    }
});
</script>
@endpush
