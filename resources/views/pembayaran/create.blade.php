@extends('layouts.app')

@section('title', 'Tambah Pembayaran')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Pembayaran</h1>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pembayaran.store') }}" method="POST">
                    @csrf
                    <!-- Tombol Cari Pemesanan -->
                    <div class="mb-3">
                        <label class="form-label">Pilih Pemesanan</label><br>
                        <button type="button" id="btnCariPemesanan" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#modalPemesanan">Cari Pemesanan</button>
                        <input type="hidden" name="pemesanan_id" id="pemesanan_id" required>
                    </div>
                    <!-- Detail Pemesanan -->
                    <div class="mb-3" id="detail-pemesanan" style="display:none;">
                        <h5>Detail Pemesanan</h5>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Pelanggan:</strong> <span id="detail-pelanggan"></span></li>
                            <li class="list-group-item"><strong>Kamar:</strong> <span id="detail-kamar"></span></li>
                            <li class="list-group-item"><strong>Tanggal Check-in:</strong> <span id="detail-checkin"></span>
                            </li>
                            <li class="list-group-item"><strong>Tanggal Check-out:</strong> <span
                                    id="detail-checkout"></span></li>
                            <li class="list-group-item"><strong>Jumlah Tamu:</strong> <span id="detail-tamu"></span></li>
                            <li class="list-group-item"><strong>Total Harga:</strong> <span id="detail-harga"></span></li>
                            <li class="list-group-item" id="info-bayar-awal" style="display:none;"><strong>Bayar Awal
                                    (DP):</strong> <span id="detail-bayar-awal"></span></li>
                            <li class="list-group-item" id="info-sisa-bayar" style="display:none;"><strong>Sisa
                                    Pembayaran:</strong> <span id="detail-sisa-bayar"></span></li>
                        </ul>
                    </div>
                    <div class="mb-3" id="input-sisa-bayar" style="display:none;">
                        <label for="jumlah_bayar" class="form-label">Jumlah yang Dibayar</label>
                        <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" min="1">
                    </div>
                    <div class="mb-3">
                        <label for="metode" class="form-label">Metode</label>
                        <select class="form-control" id="metode" name="metode" required>
                            <option value="transfer">Transfer</option>
                            <option value="kartu">Kartu</option>
                            <option value="e-wallet">E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="berhasil">Berhasil</option>
                            <option value="pending">Pending</option>
                            <option value="gagal">Gagal</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
                        <input type="date" class="form-control" id="tanggal_transaksi" name="tanggal_transaksi" required>
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
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Pemesanan -->
    <div class="modal fade" id="modalPemesanan" tabindex="-1" aria-labelledby="modalPemesananLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPemesananLabel">Cari Data Pemesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-hover" id="tabel-pemesanan">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelanggan</th>
                                <th>Kamar</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Jumlah Tamu</th>
                                <th>Total Harga</th>
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
                                    <td>{{ $p->total_harga }}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm pilih-pemesanan"
                                            data-id="{{ $p->id }}"
                                            data-pelanggan="{{ $p->pelanggan->nama_lengkap ?? '-' }}"
                                            data-kamar="{{ $p->kamar->jenis_kamar ?? '-' }}"
                                            data-checkin="{{ $p->tanggal_checkin }}"
                                            data-checkout="{{ $p->tanggal_checkout }}" data-tamu="{{ $p->jumlah_tamu }}"
                                            data-harga="{{ $p->total_harga }}" data-status="{{ $p->status }}"
                                            data-jumlah_bayar="{{ $p->jumlah_bayar }}">Pilih</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        @php
            $selectedPemesanan = null;
            if (old('pemesanan_id')) {
                $selectedPemesanan = $pemesanans->where('id', old('pemesanan_id'))->first();
            }
        @endphp

        function tampilkanInfoPembayaran(pemesanan) {
            // Tampilkan info pembayaran jika status pending (DP)
            if (pemesanan && pemesanan.status === 'pending') {
                document.getElementById('info-bayar-awal').style.display = '';
                document.getElementById('info-sisa-bayar').style.display = '';
                document.getElementById('input-sisa-bayar').style.display = '';
                document.getElementById('detail-bayar-awal').textContent = pemesanan.jumlah_bayar;
                document.getElementById('detail-sisa-bayar').textContent = pemesanan.total_harga - pemesanan.jumlah_bayar;
                document.getElementById('jumlah_bayar').value = pemesanan.total_harga - pemesanan.jumlah_bayar;
                document.getElementById('jumlah_bayar').max = pemesanan.total_harga - pemesanan.jumlah_bayar;
            } else {
                document.getElementById('info-bayar-awal').style.display = 'none';
                document.getElementById('info-sisa-bayar').style.display = 'none';
                document.getElementById('input-sisa-bayar').style.display = 'none';
                document.getElementById('jumlah_bayar').value = '';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            // Pilih pemesanan dari modal
            document.querySelectorAll('.pilih-pemesanan').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var id = this.dataset.id;
                    fetch('/pembayaran/cari-pemesanan/' + id)
                        .then(res => res.json())
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                                return;
                            }
                            document.getElementById('pemesanan_id').value = data.id;
                            document.getElementById('detail-pelanggan').textContent = data
                                .pelanggan ? data.pelanggan.nama_lengkap : '-';
                            document.getElementById('detail-kamar').textContent = data.kamar ?
                                data.kamar.jenis_kamar : '-';
                            document.getElementById('detail-checkin').textContent = data
                                .tanggal_checkin;
                            document.getElementById('detail-checkout').textContent = data
                                .tanggal_checkout;
                            document.getElementById('detail-tamu').textContent = data
                                .jumlah_tamu;
                            document.getElementById('detail-harga').textContent = data
                                .total_harga;
                            document.getElementById('detail-pemesanan').style.display = '';
                            var modal = bootstrap.Modal.getOrCreateInstance(document
                                .getElementById('modalPemesanan'));
                            modal.hide();
                            // Tampilkan info pembayaran jika status pending (DP)
                            var pemesanan = {
                                status: data.status,
                                jumlah_bayar: parseInt(data.jumlah_bayar) || 0,
                                total_harga: parseInt(data.total_harga) || 0
                            };
                            tampilkanInfoPembayaran(pemesanan);
                        });
                });
            });
        });
    </script>
@endsection
