<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::withCount(['pemesanan', 'ulasan'])->get();
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:pelanggans,email',
            'nomor_telepon' => 'required',
            'password' => 'required|min:6',
        ]);
        $data = $request->only('nama_lengkap', 'email', 'nomor_telepon');
        $data['password'] = Hash::make($request->password);
        Pelanggan::create($data);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:pelanggans,email,' . $id,
            'nomor_telepon' => 'required',
            'password' => 'nullable|min:6',
        ]);
        $data = $request->only('nama_lengkap', 'email', 'nomor_telepon');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $pelanggan->update($data);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diupdate');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
