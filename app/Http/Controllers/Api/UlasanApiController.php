<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanApiController extends Controller
{
    public function index() { return Ulasan::with(['pelanggan', 'kamar'])->get(); }
    public function show($id) { return Ulasan::with(['pelanggan', 'kamar'])->findOrFail($id); }
    public function store(Request $request) {
        $data = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kamar_id' => 'required|exists:kamars,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required',
            'tanggal_review' => 'required|date',
        ]);
        return Ulasan::create($data);
    }
    public function update(Request $request, $id) {
        $ulasan = Ulasan::findOrFail($id);
        $data = $request->validate([
            'pelanggan_id' => 'sometimes|required|exists:pelanggans,id',
            'kamar_id' => 'sometimes|required|exists:kamars,id',
            'rating' => 'sometimes|required|integer|min:1|max:5',
            'komentar' => 'sometimes|required',
            'tanggal_review' => 'sometimes|required|date',
        ]);
        $ulasan->update($data);
        return $ulasan;
    }
    public function destroy($id) { $ulasan = Ulasan::findOrFail($id); $ulasan->delete(); return response()->json(['message'=>'deleted']); }
} 