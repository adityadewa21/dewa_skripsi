@extends('layouts.index')

@section('title','Contact')

@section('content')
<section class="py-5">
    <div class="container" style="max-width:900px">

        <div class="text-center mb-5">
            <h3 class="fw-bold">📞 Hubungi Kami</h3>
            <p class="text-muted">
                Jika Anda mengalami kendala pada pesanan atau memiliki pertanyaan,
                silakan hubungi kami melalui informasi di bawah ini.
            </p>
        </div>

        <div class="row g-4">

            {{-- WHATSAPP --}}
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="bi bi-whatsapp fs-1 text-success"></i>
                        <h6 class="mt-3 fw-semibold">WhatsApp</h6>
                        <p class="text-muted small">
                            Untuk konfirmasi pembayaran, status pesanan, atau pertanyaan cepat.
                        </p>
                        <a href="https://wa.me/6289525309063"
                           target="_blank"
                           class="btn btn-outline-success btn-sm">
                            Chat WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            {{-- EMAIL --}}
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="bi bi-envelope fs-1 text-primary"></i>
                        <h6 class="mt-3 fw-semibold">Email</h6>
                        <p class="text-muted small">
                            Untuk pertanyaan detail atau keluhan tertulis.
                        </p>
                        <a href="mailto:support@tokokamu.com"
                           class="btn btn-outline-primary btn-sm">
                            dewashop@gmail.com
                        </a>
                    </div>
                </div>
            </div>

            {{-- TRACKING --}}
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 text-center">
                    <div class="card-body">
                        <i class="bi bi-truck fs-1 text-dark"></i>
                        <h6 class="mt-3 fw-semibold">Tracking Order</h6>
                        <p class="text-muted small">
                            Cek status pesanan Anda menggunakan kode order.
                        </p>
                        <a href="{{ route('order.track') }}"
                           class="btn btn-outline-dark btn-sm">
                            Lacak Pesanan
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <hr class="my-5">

        {{-- JAM OPERASIONAL --}}
        <div class="text-center">
            <h6 class="fw-semibold">⏰ Jam Operasional</h6>
            <p class="text-muted mb-1">Senin – Sabtu</p>
            <p class="text-muted">09.00 – 17.00 WIB</p>
            <small class="text-muted">
                Pesan di luar jam operasional akan dibalas pada hari kerja berikutnya.
            </small>
        </div>

    </div>
</section>
@endsection
