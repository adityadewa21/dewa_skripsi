@extends('layouts.index')

@section('title', 'Profil Saya')

@section('content')
<div class="container my-5" style="max-width: 720px;">
    <h3 class="mb-4 text-uppercase">Update Profile</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('customer.updateProfile') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">No. HP</label>
            <input type="text" name="phone"
                   class="form-control"
                   value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
        </div>

        <hr>

        <p class="text-muted mb-2">Kosongkan password jika tidak ingin mengubah</p>

        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="form-control">
        </div>

        <button class="btn btn-dark px-4">Update Profile</button>
    </form>
</div>
@endsection
