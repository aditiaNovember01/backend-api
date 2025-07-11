@extends('layouts.app')

@section('title', 'Edit Pemesanan')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Pemesanan</h1>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pemesanan.update', $pemesanan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Pelanggan</label>
                        <select class="form-control" id="pelanggan_id" name="pelanggan_id" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggans as $p)
                                <option value="{{ $p->id }}"
                                    {{ $pemesanan->pelanggan_id == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kamar_id" class="form-label">Kamar</label>
                        <select class="form-control" id="kamar_id" name="kamar_id" required>
                            <option value="">-- Pilih Kamar --</option>
                            @foreach ($kamars as $k)
                                <option value="{{ $k->id }}" {{ $pemesanan->kamar_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->jenis_kamar }} (ID: {{ $k->id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_checkin" class="form-label">Tanggal Check-in</label>
                        <input type="date" class="form-control" id="tanggal_checkin" name="tanggal_checkin"
                            value="{{ $pemesanan->tanggal_checkin }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_checkout" class="form-label">Tanggal Check-out</label>
                        <input type="date" class="form-control" id="tanggal_checkout" name="tanggal_checkout"
                            value="{{ $pemesanan->tanggal_checkout }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_tamu" class="form-label">Jumlah Tamu</label>
                        <input type="number" class="form-control" id="jumlah_tamu" name="jumlah_tamu"
                            value="{{ $pemesanan->jumlah_tamu }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="number" class="form-control" id="total_harga" name="total_harga"
                            value="{{ $pemesanan->total_harga }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <input type="text" class="form-control" id="metode_pembayaran" name="metode_pembayaran"
                            value="{{ $pemesanan->metode_pembayaran }}" required>
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
                    <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
