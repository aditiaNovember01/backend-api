@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Kamar</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('kamar.create') }}" class="btn btn-primary">Tambah Kamar</a>
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
                            <th>Jenis Kamar</th>
                            <th>Kapasitas Tamu</th>
                            <th>Fasilitas Kamar</th>
                            <th>Harga per Malam</th>
                            <th>Jumlah Kamar Tersedia</th>
                            <th>Foto Kamar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kamars as $k)
                            <tr>
                                <td>{{ $k->id }}</td>
                                <td>{{ $k->jenis_kamar }}</td>
                                <td>{{ $k->kapasitas_tamu }}</td>
                                <td>{{ $k->fasilitas_kamar }}</td>
                                <td>{{ number_format($k->harga_per_malam, 0, ',', '.') }}</td>
                                <td>{{ $k->jumlah_kamar_tersedia }}</td>
                                <td>
                                    @if ($k->foto_kamar)
                                        <img src="{{ asset('storage/' . $k->foto_kamar) }}" alt="foto kamar" width="60">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('kamar.edit', $k->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('kamar.destroy', $k->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus kamar ini?')">Hapus</button>
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
