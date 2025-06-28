@extends('layouts.app')

@section('title', 'Daftar Pelanggan')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Pelanggan</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
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
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Jumlah Pemesanan</th>
                            <th>Jumlah Ulasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggans as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->nama_lengkap }}</td>
                                <td>{{ $p->email }}</td>
                                <td>{{ $p->nomor_telepon }}</td>
                                <td>{{ $p->pemesanan_count ?? 0 }}</td>
                                <td>{{ $p->ulasan_count ?? 0 }}</td>
                                <td>
                                    <a href="{{ route('pelanggan.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pelanggan.destroy', $p->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus pelanggan ini?')">Hapus</button>
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
