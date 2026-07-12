@extends('layouts.admin')

@section('title','Data Customer')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Customer Terdaftar</h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No WhatsApp</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->phone ?? '-' }}</td>
                    <td>{{ $c->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.customers-show', $c->id) }}"
                           class="btn btn-sm btn-primary">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
