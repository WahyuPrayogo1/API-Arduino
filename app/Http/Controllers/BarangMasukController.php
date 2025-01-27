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
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'harga' => 'required',
            'tanggal_masuk' => 'required|date',
        ]);

        // Menyimpan data barang masuk
        $barangMasuk = BarangMasuk::create([
            'barang_id' => $request->barang_id, // Menyimpan barang_id yang dipilih
            'jumlah' => $request->jumlah, // Menyimpan jumlah barang yang masuk
            'harga' => str_replace(['Rp', '.', ','], '', $request->harga), // Menghapus format rupiah jika ada
            'tanggal_masuk' => $request->tanggal_masuk, // Menyimpan tanggal masuk barang
        ]);

        // Update stok di tabel barang
        $barang = Barang::find($request->barang_id); // Cari barang berdasarkan barang_id
        if ($barang) {
            $barang->stok += $request->jumlah; // Tambahkan jumlah barang masuk ke stok
            $barang->save(); // Simpan perubahan
        }

        // Redirect ke halaman daftar barang masuk dengan pesan sukses
        return redirect()->route('barang-masuk.index')->with('success', 'Barang berhasil ditambahkan dan stok diperbarui.');
    }


    public function edit(BarangMasuk $barangMasuk)
    {
        $barangs = Barang::all(); // Ambil semua barang untuk pilihan
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

        // Cari data barang masuk yang akan diedit
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Hitung selisih jumlah barang masuk sebelumnya dengan yang baru
        $selisih = $request->jumlah - $barangMasuk->jumlah;

        // Update stok di tabel barang
        $barang = Barang::find($request->barang_id); // Cari barang berdasarkan barang_id
        if ($barang) {
            $barang->stok += $selisih; // Sesuaikan stok berdasarkan selisih jumlah
            $barang->save(); // Simpan perubahan stok
        }

        // Update data barang masuk
        $barangMasuk->update([
            'barang_id' => $request->barang_id, // Perbarui barang_id jika diperlukan
            'jumlah' => $request->jumlah, // Perbarui jumlah barang masuk
            'harga' => str_replace(['Rp', '.', ','], '', $request->harga), // Menghapus format rupiah jika ada
            'tanggal_masuk' => $request->tanggal_masuk, // Perbarui tanggal masuk barang
        ]);

        // Redirect ke halaman daftar barang masuk dengan pesan sukses
        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil diperbarui dan stok telah disesuaikan.');
    }


    public function destroy($id)
    {
        // Cari data barang masuk yang akan dihapus
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Kurangi stok di tabel barang
        $barang = Barang::find($barangMasuk->barang_id);
        if ($barang) {
            $barang->stok -= $barangMasuk->jumlah; // Kurangi stok sesuai jumlah barang masuk
            $barang->save(); // Simpan perubahan stok
        }

        // Hapus data barang masuk
        $barangMasuk->delete();

        // Redirect ke halaman daftar barang masuk dengan pesan sukses
        return redirect()->route('barang-masuk.index')->with('success', 'Barang masuk berhasil dihapus dan stok diperbarui.');
    }

}
