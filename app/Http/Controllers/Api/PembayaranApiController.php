<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PembayaranApiController extends Controller
{
    public function index()
    {
        return Pembayaran::with('pemesanan')->get();
    }
    public function show($id)
    {
        return Pembayaran::with('pemesanan')->findOrFail($id);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'metode' => 'required|in:transfer,kartu,e-wallet',
            'status' => 'required|in:berhasil,pending,gagal',
            'tanggal_transaksi' => 'required|date',
        ]);
        $pembayaran = Pembayaran::create($data);
        if ($data['status'] === 'berhasil') {
            $pembayaran->pemesanan->status = 'dibayar';
            $pembayaran->pemesanan->save();
        }
        return $pembayaran;
    }
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $data = $request->validate([
            'pemesanan_id' => 'sometimes|required|exists:pemesanans,id',
            'metode' => 'sometimes|required|in:transfer,kartu,e-wallet',
            'status' => 'sometimes|required|in:berhasil,pending,gagal',
            'tanggal_transaksi' => 'sometimes|required|date',
        ]);
        $pembayaran->update($data);
        if (($data['status'] ?? $pembayaran->status) === 'berhasil') {
            $pembayaran->pemesanan->status = 'dibayar';
            $pembayaran->pemesanan->save();
        }
        return $pembayaran;
    }
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();
        return response()->json(['message' => 'deleted']);
    }
}
