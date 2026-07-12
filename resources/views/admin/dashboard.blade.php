@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<h2 class="mb-4">Dashboard</h2>

<div class="row g-4">

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Total Produk</h6>
                <h2>{{ $totalProduct }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Total Order</h6>
                <h2>{{ $totalOrder }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Customer</h6>
                <h2>{{ $totalUser }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-warning">
            <div class="card-body text-center">
                <h6>Order Pending</h6>
                <h2 class="text-warning">{{ $pendingOrder }}</h2>
            </div>
        </div>
    </div>

</div>

@endsection
