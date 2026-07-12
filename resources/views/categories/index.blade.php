@extends('layouts.admin')

@section('title', 'Category')
@push('css')
<style>
    .category-thumb {
        width: 90px;
        height: 90px;
        object-fit: cover;
        cursor: zoom-in;
        border-radius: 10px;
        transition: transform .2s;
    }

    .category-thumb:hover {
        transform: scale(1.05);
    }

    .modal-img {
        max-width: 100%;
        border-radius: 12px;
    }
</style>
@endpush

@section('content')

<div class="d-flex justify-content-between mb-4">
    <h4>Manajemen Category</h4>
    <a href="{{ route('categories.create') }}" class="btn btn-dark">
        + Tambah Category
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
<div class="card-body">
<table class="table align-middle">
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Slug</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $cat)
        <tr>
            <td>
                @if($cat->picture)
                    <img src="{{ asset('storage/'.$cat->picture) }}"
                        class="img-thumbnail category-thumb"
                        data-bs-toggle="modal"
                        data-bs-target="#imageModal"
                        data-image="{{ asset('storage/'.$cat->picture) }}">
                @endif
            </td>
            <td>{{ $cat->name }}</td>
            <td>{{ $cat->slug }}</td>
            <td>
                <a href="{{ route('categories.edit',$cat) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('categories.destroy',$cat) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Hapus?')" class="btn btn-sm btn-danger">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $categories->links() }}
</div>
</div>
<!-- Image Zoom Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-body text-center p-3">
                <img src="" class="modal-img" id="modalImage">
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    const imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', function (event) {
        const img = event.relatedTarget;
        const imageSrc = img.getAttribute('data-image');
        document.getElementById('modalImage').src = imageSrc;
    });
</script>
@endpush
