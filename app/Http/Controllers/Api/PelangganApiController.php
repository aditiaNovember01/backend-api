<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganApiController extends Controller
{
    public function index() { return Pelanggan::all(); }
    public function show($id) { return Pelanggan::findOrFail($id); }
    public function store(Request $request) {
        $data = $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:pelanggans,email',
            'nomor_telepon' => 'required',
            'password' => 'required|min:6',
        ]);
        $data['password'] = Hash::make($data['password']);
        return Pelanggan::create($data);
    }
    public function update(Request $request, $id) {
        $pelanggan = Pelanggan::findOrFail($id);
        $data = $request->validate([
            'nama_lengkap' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:pelanggans,email,'.$id,
            'nomor_telepon' => 'sometimes|required',
            'password' => 'nullable|min:6',
        ]);
        if(isset($data['password'])) $data['password'] = Hash::make($data['password']);
        $pelanggan->update($data);
        return $pelanggan;
    }
    public function destroy($id) { $pelanggan = Pelanggan::findOrFail($id); $pelanggan->delete(); return response()->json(['message'=>'deleted']); }
} 