@extends('layouts.app')

@section('title', 'Edit Pembayaran')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Pembayaran</h1>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="pemesanan_id" class="form-label">ID Pemesanan</label>
                        <select class="form-control" id="pemesanan_id" name="pemesanan_id" required>
                            <option value="">-- Pilih Pemesanan --</option>
                            @foreach ($pemesanans as $p)
                                <option value="{{ $p->id }}"
                                    {{ $pembayaran->pemesanan_id == $p->id ? 'selected' : '' }}>#{{ $p->id }} -
                                    {{ $p->pelanggan->nama_lengkap ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="metode" class="form-label">Metode</label>
                        <select class="form-control" id="metode" name="metode" required>
                            <option value="transfer" {{ $pembayaran->metode == 'transfer' ? 'selected' : '' }}>Transfer
                            </option>
                            <option value="kartu" {{ $pembayaran->metode == 'kartu' ? 'selected' : '' }}>Kartu</option>
                            <option value="e-wallet" {{ $pembayaran->metode == 'e-wallet' ? 'selected' : '' }}>E-Wallet
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="berhasil" {{ $pembayaran->status == 'berhasil' ? 'selected' : '' }}>Berhasil
                            </option>
                            <option value="pending" {{ $pembayaran->status == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="gagal" {{ $pembayaran->status == 'gagal' ? 'selected' : '' }}>Gagal</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi"
                            value="{{ $pembayaran->tanggal_transaksi }}" required>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
