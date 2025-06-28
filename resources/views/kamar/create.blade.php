@extends('layouts.app')

@section('title', 'Tambah Kamar')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tambah Kamar</h1>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('kamar.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="jenis_kamar" class="form-label">Jenis Kamar</label>
                        <input type="text" class="form-control" id="jenis_kamar" name="jenis_kamar"
                            value="{{ old('jenis_kamar') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="kapasitas_tamu" class="form-label">Kapasitas Tamu</label>
                        <input type="number" class="form-control" id="kapasitas_tamu" name="kapasitas_tamu"
                            value="{{ old('kapasitas_tamu') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="fasilitas_kamar" class="form-label">Fasilitas Kamar</label>
                        <textarea class="form-control" id="fasilitas_kamar" name="fasilitas_kamar" required>{{ old('fasilitas_kamar') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="harga_per_malam" class="form-label">Harga per Malam</label>
                        <input type="number" class="form-control" id="harga_per_malam" name="harga_per_malam"
                            value="{{ old('harga_per_malam') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_kamar_tersedia" class="form-label">Jumlah Kamar Tersedia</label>
                        <input type="number" class="form-control" id="jumlah_kamar_tersedia" name="jumlah_kamar_tersedia"
                            value="{{ old('jumlah_kamar_tersedia') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="foto_kamar" class="form-label">Foto Kamar</label>
                        <input type="file" class="form-control" id="foto_kamar" name="foto_kamar" accept="image/*">
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
                    <a href="{{ route('kamar.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
