<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Pelanggan;
use App\Models\Kamar;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::with(['pelanggan', 'kamar'])->get();
        return view('ulasan.index', compact('ulasans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        $kamars = Kamar::all();
        return view('ulasan.create', compact('pelanggans', 'kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kamar_id' => 'required|exists:kamars,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required',
            'tanggal_review' => 'required|date',
        ]);
        Ulasan::create($request->all());
        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $pelanggans = Pelanggan::all();
        $kamars = Kamar::all();
        return view('ulasan.edit', compact('ulasan', 'pelanggans', 'kamars'));
    }

    public function update(Request $request, $id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'kamar_id' => 'required|exists:kamars,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required',
            'tanggal_review' => 'required|date',
        ]);
        $ulasan->update($request->all());
        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil diupdate');
    }

    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        $ulasan->delete();
        return redirect()->route('ulasan.index')->with('success', 'Ulasan berhasil dihapus');
    }
}
