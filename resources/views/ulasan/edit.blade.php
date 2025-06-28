@extends('layouts.app')

@section('title', 'Edit Ulasan')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Ulasan</h1>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('ulasan.update', $ulasan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="pelanggan_id" class="form-label">Pelanggan</label>
                        <select class="form-control" id="pelanggan_id" name="pelanggan_id" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($pelanggans as $p)
                                <option value="{{ $p->id }}" {{ $ulasan->pelanggan_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_lengkap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kamar_id" class="form-label">Kamar</label>
                        <select class="form-control" id="kamar_id" name="kamar_id" required>
                            <option value="">-- Pilih Kamar --</option>
                            @foreach ($kamars as $k)
                                <option value="{{ $k->id }}" {{ $ulasan->kamar_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->jenis_kamar }} (ID: {{ $k->id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select class="form-control" id="rating" name="rating" required>
                            <option value="">-- Pilih Rating --</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $ulasan->rating == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar / Ulasan</label>
                        <textarea class="form-control" id="komentar" name="komentar" required>{{ old('komentar', $ulasan->komentar) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_review" class="form-label">Tanggal Review</label>
                        <input type="date" class="form-control" id="tanggal_review" name="tanggal_review"
                            value="{{ $ulasan->tanggal_review }}" required>
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
                    <a href="{{ route('ulasan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection
