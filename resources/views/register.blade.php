@extends('layouts.index')

@section('title', 'Daftar Akun')

@section('content')

<section class="register py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-75">

            <div class="col-md-5" data-aos="fade-up">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">

                        <h3 class="text-center text-uppercase mb-4">
                            Daftar Akun
                        </h3>

                        <p class="text-center text-muted mb-4">
                            Buat akun untuk mulai berbelanja
                        </p>

                        {{-- ERROR --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register.process') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control form-control-lg"
                                    value="{{ old('name') }}"
                                    placeholder="Nama Anda"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control form-control-lg"
                                    value="{{ old('email') }}"
                                    placeholder="email@example.com"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="address" cols="3" rows="2"class="form-control form-control-lg"
                                    value="{{ old('address') }}"
                                    placeholder="Alamat Lengkap" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No. Whatsapp</label>
                                <input
                                    type="number"
                                    name="phone"
                                    class="form-control form-control-lg"
                                    value="{{ old('address') }}"
                                    placeholder="Nomor WA"
                                    required
                                >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control form-control-lg"
                                    placeholder="Minimal 6 karakter"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Konfirmasi Password</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control form-control-lg"
                                    placeholder="Ulangi password"
                                    required
                                >
                            </div>

                            <button class="btn btn-dark w-100 btn-lg text-uppercase">
                                Daftar
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                Sudah punya akun?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                    Login
                                </a>
                            </small>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
