<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Barang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $penjualans = Penjualan::with('barang');

        // Jika ada filter tanggal, tambahkan kondisi untuk tanggal
        if ($request->has('tanggal') && $request->tanggal) {
            $penjualans->whereDate('tanggal_penjualan', $request->tanggal);
        }

        if ($request->ajax()) {
            return DataTables::of($penjualans)
                ->addColumn('total_harga', function($row) {
                    // Menghitung total harga berdasarkan jumlah dan harga
                    return 'Rp ' . number_format($row->jumlah * $row->harga, 0, ',', '.');
                })
                ->addColumn('tanggal_penjualan', function($row) {
                    return $row->tanggal_penjualan ? \Carbon\Carbon::parse($row->tanggal_penjualan)->format('d-m-Y') : 'Tanggal Tidak Tersedia';
                })
                ->addColumn('aksi', function($row) {
                    // Tombol aksi untuk penjualan
                    return view('backend.pages.penjualans.actions', compact('row'));
                })
                ->rawColumns(['aksi']) // Menandakan kolom yang mengandung HTML
                ->make(true);
        }

        return view('backend.pages.penjualans.index');
    }



    public function create()
    {
        // Ambil semua data produk (barang)
        $barangs = Barang::all(); // Pastikan model Barang sudah ada

        // Tampilkan form create dengan data barang
        return view('backend.pages.penjualans.create', compact('barangs'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'barang_id' => 'required|exists:barangs,id', // Pastikan barang_id valid
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required|numeric|min:1',
            'tanggal_penjualan' => 'required|date',
        ]);

        // Ambil data barang berdasarkan barang_id
        $barang = Barang::findOrFail($request->barang_id);

        // Periksa apakah stok cukup
        if ($barang->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok barang tidak cukup!');
        }

        // Hitung total harga
        $total_harga = $request->jumlah * $request->harga;

        // Simpan penjualan ke database
        $penjualan = Penjualan::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'total_harga' => $total_harga,
            'tanggal_penjualan' => $request->tanggal_penjualan,
        ]);

        // Kurangi stok barang yang terjual
        $barang->stok -= $request->jumlah;
        $barang->save();

        // Redirect setelah berhasil
        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil ditambahkan dan stok barang berhasil diperbarui!');
    }


    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id); // Mengambil data penjualan berdasarkan ID
        $barangs = Barang::all(); // Mengambil semua data barang
        return view('backend.pages.penjualans.edit', compact('penjualan', 'barangs')); // Mengirim data ke view
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required|numeric|min:1',
            'tanggal_penjualan' => 'required|date',
            'total_harga' => 'required|numeric|min:1',
        ]);

        // Ambil data penjualan yang akan diupdate
        $penjualan = Penjualan::findOrFail($id);

        // Menyimpan jumlah lama penjualan untuk perhitungan stok
        $jumlahLama = $penjualan->jumlah;
        $barangLama = $penjualan->barang_id;

        // Update data penjualan
        $penjualan->update([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga' => $request->harga,
            'tanggal_penjualan' => $request->tanggal_penjualan,
            'total_harga' => $request->total_harga,
        ]);

        // Ambil data barang yang baru dan lama
        $barangBaru = Barang::findOrFail($request->barang_id);
        $barangLama = Barang::findOrFail($barangLama);

        // Menghitung perubahan stok
        $perubahanStok = $request->jumlah - $jumlahLama;

        // Update stok barang
        if ($perubahanStok > 0) {
            // Jika penjualan bertambah, kurangi stok barang
            $barangBaru->stok -= $perubahanStok;
        } else {
            // Jika penjualan berkurang, tambahkan stok barang
            $barangBaru->stok += abs($perubahanStok); // Menggunakan abs() untuk memastikan nilai positif
        }

        // Pastikan stok barang lama dikembalikan
        if ($barangLama->id !== $barangBaru->id) {
            $barangLama->stok += $jumlahLama; // Mengembalikan stok barang lama
        }

        $barangBaru->save();
        $barangLama->save();

        // Redirect atau memberi respons
        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil diperbarui!');
    }
    public function destroy($id)
    {
        // Ambil data penjualan yang akan dihapus
        $penjualan = Penjualan::findOrFail($id);

        // Ambil data barang terkait
        $barang = Barang::findOrFail($penjualan->barang_id);

        // Tambah stok barang sesuai dengan jumlah penjualan yang dihapus
        $barang->stok += $penjualan->jumlah;

        // Simpan perubahan stok barang
        $barang->save();

        // Hapus data penjualan
        $penjualan->delete();

        // Redirect atau memberi respons
        return redirect()->route('sales.index')->with('success', 'Penjualan berhasil dihapus dan stok barang diperbarui.');
    }

}
