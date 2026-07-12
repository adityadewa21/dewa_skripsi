@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')

<div class="card">
<div class="card-body">
    <h5 class="mb-4">Edit Category</h5>

    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Category</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Category</label>
            <input type="file" name="picture" class="form-control">

            @if($category->picture)
                <div class="mt-2">
                    <img src="{{ asset('storage/'.$category->picture) }}" width="120" class="rounded">
                </div>
            @endif
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('categories') }}" class="btn btn-secondary">Kembali</a>
            <button class="btn btn-dark">Update</button>
        </div>
    </form>
</div>
</div>

@endsection
