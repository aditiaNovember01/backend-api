@extends('layouts.app')

@section('title', 'Daftar Pemesanan')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Pemesanan</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('pemesanan.create') }}" class="btn btn-primary">Tambah Pemesanan</a>
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
                            <th>Pelanggan</th>
                            <th>Kamar</th>
                            <th>Tgl Check-in</th>
                            <th>Tgl Check-out</th>
                            <th>Jumlah Tamu</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Metode Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemesanans as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->pelanggan->nama_lengkap ?? '-' }}</td>
                                <td>{{ $p->kamar->jenis_kamar ?? '-' }}</td>
                                <td>{{ $p->tanggal_checkin }}</td>
                                <td>{{ $p->tanggal_checkout }}</td>
                                <td>{{ $p->jumlah_tamu }}</td>
                                <td>{{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $badge = [
                                            'pending' => 'badge badge-warning',
                                            'dibayar' => 'badge badge-success',
                                            'dibatalkan' => 'badge badge-danger',
                                            'selesai' => 'badge badge-info',
                                        ];
                                    @endphp
                                    <span
                                        class="{{ $badge[$p->status] ?? 'badge badge-secondary' }}">{{ ucfirst($p->status) }}</span>
                                </td>
                                <td>{{ $p->metode_pembayaran }}</td>
                                <td>
                                    <a href="{{ route('pemesanan.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('pemesanan.destroy', $p->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus pemesanan ini?')">Hapus</button>
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
