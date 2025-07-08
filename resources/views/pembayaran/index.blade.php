@extends('layouts.app')

@section('title', 'Daftar Pembayaran')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Pembayaran</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">Tambah Pembayaran</a>
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
                            <th>ID Pemesanan</th>
                            <th>Nama Pelanggan</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Tanggal Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->pemesanan_id }}</td>
                                <td>{{ $p->pemesanan->pelanggan->nama_lengkap ?? '-' }}</td>
                                <td>{{ ucfirst($p->metode) }}</td>
                                <td>
                                    @php
                                        $badge = [
                                            'berhasil' => 'badge badge-success',
                                            'pending' => 'badge badge-warning',
                                            'gagal' => 'badge badge-danger',
                                        ];
                                    @endphp
                                    <span
                                        class="{{ $badge[$p->status] ?? 'badge badge-secondary' }}">{{ ucfirst($p->status) }}</span>
                                </td>
                                <td>{{ $p->tanggal_transaksi }}</td>
                                <td>
                                    <a href="{{ route('pembayaran.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus pembayaran ini?')">Hapus</button>
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
