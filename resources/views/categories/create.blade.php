@extends('layouts.admin')

@section('title', 'Tambah Category')

@section('content')

<div class="card">
<div class="card-body">
    <h5 class="mb-4">Tambah Category</h5>

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Category</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Category</label>
            <input type="file" name="picture" class="form-control">
            <small class="text-muted">Format jpg / png</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('categories') }}" class="btn btn-secondary">Kembali</a>
            <button class="btn btn-dark">Simpan</button>
        </div>
    </form>
</div>
</div>

@endsection
