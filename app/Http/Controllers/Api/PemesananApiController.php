<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PemesananApiController extends Controller
{
    public function index()
    {
        return Pemesanan::with(['pelanggan', 'kamar'])->get();
    }
    public function show($id)
    {
        return Pemesanan::with(['pelanggan', 'kamar'])->findOrFail($id);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kamar_id' => 'required|exists:kamars,id',
            'tanggal_checkin' => 'required|date',
            'tanggal_checkout' => 'required|date|after_or_equal:tanggal_checkin',
            'jumlah_tamu' => 'required|integer',
            'total_harga' => 'required|numeric',
            'metode_pembayaran' => 'required',
        ]);
        $kamar = \App\Models\Kamar::findOrFail($data['kamar_id']);
        if ($data['jumlah_tamu'] > $kamar->kapasitas_tamu) {
            return response()->json(['error' => 'Jumlah tamu melebihi kapasitas kamar, silakan pilih kamar lain.'], 422);
        }
        $data['status'] = 'pending';
        return Pemesanan::create($data);
    }
    public function update(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $data = $request->validate([
            'pelanggan_id' => 'sometimes|required|exists:pelanggans,id',
            'kamar_id' => 'sometimes|required|exists:kamars,id',
            'tanggal_checkin' => 'sometimes|required|date',
            'tanggal_checkout' => 'sometimes|required|date|after_or_equal:tanggal_checkin',
            'jumlah_tamu' => 'sometimes|required|integer',
            'total_harga' => 'sometimes|required|numeric',
            'metode_pembayaran' => 'sometimes|required',
        ]);
        if (isset($data['kamar_id'])) {
            $kamar = \App\Models\Kamar::findOrFail($data['kamar_id']);
            if (($data['jumlah_tamu'] ?? $pemesanan->jumlah_tamu) > $kamar->kapasitas_tamu) {
                return response()->json(['error' => 'Jumlah tamu melebihi kapasitas kamar, silakan pilih kamar lain.'], 422);
            }
        }
        $pemesanan->update($data);
        return $pemesanan;
    }
    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->delete();
        return response()->json(['message' => 'deleted']);
    }
}
