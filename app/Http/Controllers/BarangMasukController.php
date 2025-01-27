<?php

namespace App\Http\Controllers;

use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuks = BarangMasuk::with('barang')->get();
        return view('backend.pages.barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('backend.pages.barang_masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required',
            'tanggal_masuk' => 'required|date',
        ]);

        // Menyimpan data barang masuk
        $barangMasuk = BarangMasuk::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga' => str_replace(['Rp', '.', ','], '', $request->harga),
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        // Update stok di tabel barang
        $barang = Barang::find($request->barang_id);
        if ($barang) {
            $barang->stok += $request->jumlah;
            $barang->save();
        }
        return redirect()->route('barang-masuk.index')->with('success', 'Barang berhasil ditambahkan dan stok diperbarui.');
    }


    public function edit(BarangMasuk $barangMasuk)
    {
        $barangs = Barang::all();
        $formattedTanggalMasuk = \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d-m-Y');

        return view('backend.pages.barang_masuk.edit', compact('barangMasuk', 'barangs','formattedTanggalMasuk'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required',
            'tanggal_masuk' => 'required|date',
        ]);


        $barangMasuk = BarangMasuk::findOrFail($id);

        // Hitung selisih jumlah barang masuk sebelumnya dengan yang baru
        $selisih = $request->jumlah - $barangMasuk->jumlah;

        // Update stok di tabel barang
        $barang = Barang::find($request->barang_id);
        if ($barang) {
            $barang->stok += $selisih;
            $barang->save();
        }

        // Update data barang masuk
        $barangMasuk->update([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga' => str_replace(['Rp', '.', ','], '', $request->harga),
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil diperbarui dan stok telah disesuaikan.');
    }


    public function destroy($id)
    {
        // Cari data barang masuk yang akan dihapus
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Kurangi stok di tabel barang
        $barang = Barang::find($barangMasuk->barang_id);
        if ($barang) {
            $barang->stok -= $barangMasuk->jumlah;
            $barang->save();
        }

        // Hapus data barang masuk
        $barangMasuk->delete();

        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil dihapus dan stok diperbarui.');
    }

}
