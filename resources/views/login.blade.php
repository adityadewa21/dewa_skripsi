@extends('layouts.index')

@section('title', 'Login')

@section('content')

<section class="login py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-75">

            <div class="col-md-5" data-aos="fade-up">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">

                        <h3 class="text-center text-uppercase mb-4">
                            Login Account
                        </h3>

                        <p class="text-center text-muted mb-4">
                            Masuk untuk melanjutkan belanja atau mengelola toko
                        </p>

                        {{-- ERROR --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.process') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control form-control-lg"
                                    placeholder="email@example.com"
                                    value="{{ old('email') }}"
                                    required
                                >
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control form-control-lg"
                                    placeholder="********"
                                    required
                                >
                            </div>

                            <button class="btn btn-dark w-100 btn-lg text-uppercase">
                                Login
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                Belum punya akun?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                    Daftar Sekarang
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
