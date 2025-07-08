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
        // Cek apakah pelanggan sudah pernah memesan kamar
        $existing = Pemesanan::where('pelanggan_id', $request->pelanggan_id)->exists();
        if ($existing) {
            return back()->withInput()->withErrors(['pelanggan_id' => 'Pelanggan ini sudah pernah melakukan pemesanan kamar.']);
        }
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kamar_id' => 'required|exists:kamars,id',
            'tanggal_checkin' => 'required|date',
            'tanggal_checkout' => 'required|date|after_or_equal:tanggal_checkin',
            'jumlah_tamu' => 'required|integer',
            'metode_pembayaran' => 'required',
        ]);
        $kamar = Kamar::findOrFail($request->kamar_id);
        if ($request->jumlah_tamu > $kamar->kapasitas_tamu) {
            return back()->withInput()->withErrors(['jumlah_tamu' => 'Jumlah tamu melebihi kapasitas kamar, silakan pilih kamar lain.']);
        }
        $data = $request->only('pelanggan_id', 'kamar_id', 'tanggal_checkin', 'tanggal_checkout', 'jumlah_tamu', 'metode_pembayaran', 'tipe_pembayaran');
        // Hitung jumlah malam
        $checkin = new \DateTime($request->tanggal_checkin);
        $checkout = new \DateTime($request->tanggal_checkout);
        $interval = $checkin->diff($checkout);
        $jumlah_malam = $interval->days > 0 ? $interval->days : 1;
        // Ambil harga kamar
        $kamar = Kamar::findOrFail($request->kamar_id);
        $data['total_harga'] = $kamar->harga_per_malam * $jumlah_malam;
        // Logika pembayaran
        if ($request->tipe_pembayaran === 'dp') {
            $data['status'] = 'pending';
            $data['jumlah_bayar'] = round($data['total_harga'] * 0.2);
        } else {
            $data['status'] = 'dibayar';
            $data['jumlah_bayar'] = $data['total_harga'];
        }
        // Pastikan jumlah_bayar tidak null
        if (!isset($data['jumlah_bayar']) || $data['jumlah_bayar'] === null) {
            $data['jumlah_bayar'] = 0;
        }
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

    // Method untuk update status pemesanan
    public function updateStatus($id, $status)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status = $status;
        $pemesanan->save();
        return redirect()->route('pemesanan.index')->with('success', 'Status pemesanan diupdate');
    }

    // Method untuk mengambil detail pemesanan (AJAX)
    public function detail($id)
    {
        $pemesanan = \App\Models\Pemesanan::with(['pelanggan', 'kamar'])->find($id);
        if (!$pemesanan) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }
        return response()->json($pemesanan);
    }
}
