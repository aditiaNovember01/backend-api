<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::all();
        return view('kamar.index', compact('kamars'));
    }

    public function create()
    {
        return view('kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_kamar' => 'required',
            'kapasitas_tamu' => 'required|integer',
            'fasilitas_kamar' => 'required',
            'harga_per_malam' => 'required|numeric',
            'jumlah_kamar_tersedia' => 'required|integer',
            'foto_kamar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->only('jenis_kamar', 'kapasitas_tamu', 'fasilitas_kamar', 'harga_per_malam', 'jumlah_kamar_tersedia');
        if ($request->hasFile('foto_kamar')) {
            $data['foto_kamar'] = $request->file('foto_kamar')->store('kamar', 'public');
        }
        Kamar::create($data);
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        return view('kamar.edit', compact('kamar'));
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);
        $request->validate([
            'jenis_kamar' => 'required',
            'kapasitas_tamu' => 'required|integer',
            'fasilitas_kamar' => 'required',
            'harga_per_malam' => 'required|numeric',
            'jumlah_kamar_tersedia' => 'required|integer',
            'foto_kamar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $data = $request->only('jenis_kamar', 'kapasitas_tamu', 'fasilitas_kamar', 'harga_per_malam', 'jumlah_kamar_tersedia');
        if ($request->hasFile('foto_kamar')) {
            $data['foto_kamar'] = $request->file('foto_kamar')->store('kamar', 'public');
        }
        $kamar->update($data);
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diupdate');
    }

    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();
        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus');
    }
}
