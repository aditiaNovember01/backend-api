<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\Kamar;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanans = Pemesanan::with(['pelanggan', 'kamar'])->get();
        return view('pemesanan.index', compact('pemesanans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $kamars = Kamar::all();
        return view('pemesanan.create', compact('pelanggans', 'kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kamar_id' => 'required|exists:kamars,id',
            'tanggal_checkin' => 'required|date',
            'tanggal_checkout' => 'required|date|after_or_equal:tanggal_checkin',
            'jumlah_tamu' => 'required|integer',
            'total_harga' => 'required|numeric',
            'metode_pembayaran' => 'required',
        ]);
        $kamar = Kamar::findOrFail($request->kamar_id);
        if ($request->jumlah_tamu > $kamar->kapasitas_tamu) {
            return back()->withInput()->withErrors(['jumlah_tamu' => 'Jumlah tamu melebihi kapasitas kamar, silakan pilih kamar lain.']);
        }
        $data = $request->only('pelanggan_id', 'kamar_id', 'tanggal_checkin', 'tanggal_checkout', 'jumlah_tamu', 'total_harga', 'metode_pembayaran');
        $data['status'] = 'dibayar'; // Atur status otomatis
        Pemesanan::create($data);
        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pelanggans = Pelanggan::all();
        $kamars = Kamar::all();
        return view('pemesanan.edit', compact('pemesanan', 'pelanggans', 'kamars'));
    }

    public function update(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kamar_id' => 'required|exists:kamars,id',
            'tanggal_checkin' => 'required|date',
            'tanggal_checkout' => 'required|date|after_or_equal:tanggal_checkin',
            'jumlah_tamu' => 'required|integer',
            'total_harga' => 'required|numeric',
            'metode_pembayaran' => 'required',
        ]);
        $kamar = Kamar::findOrFail($request->kamar_id);
        if ($request->jumlah_tamu > $kamar->kapasitas_tamu) {
            return back()->withInput()->withErrors(['jumlah_tamu' => 'Jumlah tamu melebihi kapasitas kamar, silakan pilih kamar lain.']);
        }
        $data = $request->only('pelanggan_id', 'kamar_id', 'tanggal_checkin', 'tanggal_checkout', 'jumlah_tamu', 'total_harga', 'metode_pembayaran');
        $data['status'] = $pemesanan->status; // Status tetap, atau bisa diatur sesuai logika
        $pemesanan->update($data);
        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil diupdate');
    }

    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->delete();
        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dihapus');
    }
}
