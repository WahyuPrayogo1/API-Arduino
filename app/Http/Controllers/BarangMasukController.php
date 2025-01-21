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
        $barangMasuks = BarangMasuk::with('barang')->get(); // Menampilkan semua barang masuk beserta relasi barang
        return view('backend.pages.barang_masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::all(); // Ambil semua barang untuk pilihan
        return view('backend.pages.barang_masuk.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'barang_id' => 'required|exists:barangs,id', // Pastikan barang_id ada di tabel barangs
            'jumlah' => 'required|integer|min:1', // Validasi jumlah barang
            'harga' => 'required', // Validasi harga
            'tanggal_masuk' => 'required|date', // Validasi tanggal masuk
        ]);

        // Menyimpan data barang masuk
        BarangMasuk::create([
            'barang_id' => $request->barang_id, // Menyimpan barang_id yang dipilih
            'jumlah' => $request->jumlah, // Menyimpan jumlah barang yang masuk
            'harga' => str_replace(['Rp', '.', ','], '', $request->harga), // Menghapus format rupiah jika ada
            'tanggal_masuk' => $request->tanggal_masuk, // Menyimpan tanggal masuk barang
        ]);

        // Redirect ke halaman daftar barang masuk dengan pesan sukses
        return redirect()->route('barang-masuk.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        $barangs = Barang::all(); // Ambil semua barang untuk pilihan
        $formattedTanggalMasuk = \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d-m-Y');

        return view('backend.pages.barang_masuk.edit', compact('barangMasuk', 'barangs','formattedTanggalMasuk'));
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
{

    // Validasi data yang diterima
    $request->validate([
        'barang_id' => 'required|exists:barangs,id',
        'jumlah' => 'required|integer|min:1',
        'harga' => 'required',
        'tanggal_masuk' => 'required|date',
    ]);

    // Menghapus simbol 'Rp' pada harga
    $harga = preg_replace('/[^0-9]/', '', $request->harga);

    // Mengupdate data barang masuk
    $barangMasuk->update([
        'barang_id' => $request->barang_id,
        'jumlah' => $request->jumlah,
        'harga' => $harga,
       'tanggal_masuk' => $request->tanggal_masuk,// Mengonversi tanggal yang diterima menjadi format yang sesuai
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil diupdate');
}


    public function destroy(BarangMasuk $barangMasuk)
    {
        $barangMasuk->delete();
        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil dihapus');
    }
}
