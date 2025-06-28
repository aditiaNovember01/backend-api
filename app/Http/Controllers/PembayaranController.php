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
        ]);
        Pembayaran::create($request->all());
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
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diupdate');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus');
    }
}
