@extends('layouts.index')

@section('title','Tracking Pesanan')

@section('content')
<section class="py-5">
    <div class="container" style="max-width:500px">

        <h4 class="mb-4 text-center">Tracking Pesanan</h4>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('order.result-track') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kode Pesanan</label>
                <input type="text"
                       name="order_code"
                       class="form-control"
                       placeholder="ORD-XXXXXXX"
                       required>
            </div>

            <button class="btn btn-dark w-100">
                Cek Pesanan
            </button>
        </form>

    </div>
</section>
@endsection

