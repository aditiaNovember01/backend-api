@extends('layouts.app')

@section('title', 'Daftar Ulasan')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Ulasan</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('ulasan.create') }}" class="btn btn-primary">Tambah Ulasan</a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Pelanggan</th>
                            <th>Kamar</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Tanggal Review</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ulasans as $u)
                            <tr>
                                <td>{{ $u->id }}</td>
                                <td>{{ $u->pelanggan->nama_lengkap ?? '-' }}</td>
                                <td>{{ $u->kamar->jenis_kamar ?? '-' }}</td>
                                <td>{{ $u->rating }}</td>
                                <td>{{ $u->komentar }}</td>
                                <td>{{ $u->tanggal_review }}</td>
                                <td>
                                    <a href="{{ route('ulasan.edit', $u->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('ulasan.destroy', $u->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus ulasan ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
