@extends('layouts.admin')

@section('title','Detail Customer')

@section('content')
<div class="card" style="max-width:500px">
    <div class="card-header">
        <h5>Profil Customer</h5>
    </div>

    <div class="card-body">
        <p>
            <strong>Nama</strong><br>
            {{ $user->name }}
        </p>

        <p>
            <strong>Email</strong><br>
            {{ $user->email }}
        </p>

        <p>
            <strong>No WhatsApp</strong><br>
            {{ $user->phone ?? '-' }}
        </p>

        <p>
            <strong>Alamat</strong><br>
            {{ $user->address ?? '-' }}
        </p>

        @if($user->phone)
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$user->phone) }}"
           target="_blank"
           class="btn btn-success w-100 mt-2">
            Hubungi via WhatsApp
        </a>
        @endif
    </div>
</div>
@endsection
