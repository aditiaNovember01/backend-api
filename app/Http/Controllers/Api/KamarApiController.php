<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarApiController extends Controller
{
    public function index()
    {
        return Kamar::all();
    }
    public function show($id)
    {
        return Kamar::findOrFail($id);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_kamar' => 'required',
            'kapasitas_tamu' => 'required|integer',
            'fasilitas_kamar' => 'required',
            'harga_per_malam' => 'required|numeric',
            'jumlah_kamar_tersedia' => 'required|integer',
            'foto_kamar' => 'nullable|string',
        ]);
        return Kamar::create($data);
    }
    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);
        $data = $request->validate([
            'jenis_kamar' => 'sometimes|required',
            'kapasitas_tamu' => 'sometimes|required|integer',
            'fasilitas_kamar' => 'sometimes|required',
            'harga_per_malam' => 'sometimes|required|numeric',
            'jumlah_kamar_tersedia' => 'sometimes|required|integer',
            'foto_kamar' => 'nullable|string',
        ]);
        $kamar->update($data);
        return $kamar;
    }
    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();
        return response()->json(['message' => 'deleted']);
    }
}
