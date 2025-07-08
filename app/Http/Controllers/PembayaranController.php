<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with('pemesanan')->get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        $pemesanans = Pemesanan::all();
        return view('pembayaran.create', compact('pemesanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'metode' => 'required|in:transfer,kartu,e-wallet',
            'status' => 'required|in:berhasil,pending,gagal',
            'tanggal_transaksi' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:1',
        ]);
        $pembayaran = Pembayaran::create($request->all());
        $pemesanan = $pembayaran->pemesanan;
        // Jika status pemesanan pending (DP), tambahkan jumlah_bayar
        if ($pemesanan->status === 'pending') {
            $pemesanan->jumlah_bayar += $request->jumlah_bayar;
            // Jika sudah lunas, update status jadi dibayar
            if ($pemesanan->jumlah_bayar >= $pemesanan->total_harga) {
                $pemesanan->status = 'dibayar';
            }
            $pemesanan->save();
        }
        // Jika pembayaran berhasil dan status sudah bukan pending, pastikan status dibayar
        if ($request->status === 'berhasil' && $pemesanan->status !== 'pending') {
            $pemesanan->status = 'dibayar';
            $pemesanan->save();
        }
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pemesanans = Pemesanan::all();
        return view('pembayaran.edit', compact('pembayaran', 'pemesanans'));
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'metode' => 'required|in:transfer,kartu,e-wallet',
            'status' => 'required|in:berhasil,pending,gagal',
            'tanggal_transaksi' => 'required|date',
        ]);
        $pembayaran->update($request->all());
        // Update status pemesanan jika pembayaran berhasil
        if ($request->status === 'berhasil') {
            $pembayaran->pemesanan->status = 'dibayar';
            $pembayaran->pemesanan->save();
        }
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diupdate');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus');
    }

    public function detail($id)
    {
        $pemesanan = \App\Models\Pemesanan::with(['pelanggan', 'kamar'])->find($id);
        if (!$pemesanan) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }
        return response()->json($pemesanan);
    }

    // Method untuk mengambil detail pemesanan (AJAX)
    public function cariPemesanan($id)
    {
        $pemesanan = \App\Models\Pemesanan::with(['pelanggan', 'kamar'])->find($id);
        if (!$pemesanan) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }
        return response()->json($pemesanan);
    }
}
