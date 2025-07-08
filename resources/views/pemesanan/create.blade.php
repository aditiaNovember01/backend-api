@extends('layouts.app')

@section('title', 'Tambah Pemesanan')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Pemesanan</h1>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('pemesanan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Pelanggan</label>
                        <select class="form-control" id="pelanggan_id" name="pelanggan_id" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggans as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kamar_id" class="form-label">Kamar</label>
                        <select class="form-control" id="kamar_id" name="kamar_id" required>
                            <option value="">-- Pilih Kamar --</option>
                            @foreach ($kamars as $k)
                                <option value="{{ $k->id }}" data-harga="{{ $k->harga_per_malam }}">
                                    {{ $k->jenis_kamar }} (ID: {{ $k->id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga_per_malam" class="form-label">Harga per Malam</label>
                        <input type="number" class="form-control" id="harga_per_malam" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_checkin" class="form-label">Tanggal Check-in</label>
                        <input type="date" class="form-control" id="tanggal_checkin" name="tanggal_checkin" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_checkout" class="form-label">Tanggal Check-out</label>
                        <input type="date" class="form-control" id="tanggal_checkout" name="tanggal_checkout" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_tamu" class="form-label">Jumlah Tamu</label>
                        <input type="number" class="form-control" id="jumlah_tamu" name="jumlah_tamu" required
                            value="{{ old('jumlah_tamu') }}">
                        @error('jumlah_tamu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="number" class="form-control" id="total_harga" name="total_harga" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                        <select class="form-control" id="tipe_pembayaran" name="tipe_pembayaran" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="lunas">Lunas (Full Payment)</option>
                            <option value="dp">Bayar di Muka (DP 20%)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_bayar" class="form-label">Jumlah yang Harus Dibayar</label>
                        <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" readonly>
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
                    <a href="{{ route('pemesanan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function hitungTotalHarga() {
            const harga = parseInt(document.getElementById('harga_per_malam').value) || 0;
            const tglCheckin = document.getElementById('tanggal_checkin').value;
            const tglCheckout = document.getElementById('tanggal_checkout').value;
            let jumlahMalam = 1;
            if (tglCheckin && tglCheckout) {
                const d1 = new Date(tglCheckin);
                const d2 = new Date(tglCheckout);
                const diff = (d2 - d1) / (1000 * 60 * 60 * 24);
                jumlahMalam = diff > 0 ? diff : 1;
            }
            const total = harga * jumlahMalam;
            document.getElementById('total_harga').value = total;
            hitungJumlahBayar();
        }

        function hitungJumlahBayar() {
            const total = parseInt(document.getElementById('total_harga').value) || 0;
            const tipe = document.getElementById('tipe_pembayaran').value;
            let bayar = total;
            if (tipe === 'dp') {
                bayar = Math.round(total * 0.2);
            }
            document.getElementById('jumlah_bayar').value = bayar;
        }
        document.addEventListener('DOMContentLoaded', function() {
            const kamarSelect = document.getElementById('kamar_id');
            kamarSelect.addEventListener('change', function() {
                const harga = kamarSelect.options[kamarSelect.selectedIndex].getAttribute('data-harga') ||
                    0;
                document.getElementById('harga_per_malam').value = harga;
                hitungTotalHarga();
            });
            document.getElementById('tanggal_checkin').addEventListener('change', hitungTotalHarga);
            document.getElementById('tanggal_checkout').addEventListener('change', hitungTotalHarga);
            document.getElementById('tipe_pembayaran').addEventListener('change', hitungJumlahBayar);
        });
    </script>
@endsection
