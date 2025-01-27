<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('backend.pages.barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('backend.pages.barang.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:100|unique:barangs',
            'stok' => 'required|integer',
            'harga' => 'required|string',
        ]);

        $harga = preg_replace('/[^0-9]/', '', $request->harga);
        Barang::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'stok' => $request->stok,
            'harga' => $harga,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        return view('backend.pages.barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:100',
            'stok' => 'required|integer',
            'harga' => 'required|string',
        ]);

        // Menghapus simbol "Rp" dan karakter non-angka dari harga
        $harga = preg_replace('/[^0-9]/', '', $request->harga);

        $barang->update([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'stok' => $request->stok,
            'harga' => $harga,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
    }


    // Menghapus barang
    public function destroy(Barang $barang)
    {
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
