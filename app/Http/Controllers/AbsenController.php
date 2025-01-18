<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    // Menampilkan semua data absensi
    public function index()
    {
        $absens = Absen::with('user')->get();
        return view('backend.pages.absens.index', compact('absens'));
    }

    // Menampilkan form untuk membuat absensi baru
    public function create()
    {
        $users = User::all();
        return view('backend.pages.absens.create', compact('users'));
    }

    // Menyimpan data absensi baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rfid' => 'required|string',
            'waktu_masuk' => 'required|date',
            'waktu_keluar' => 'nullable|date', // Tambahkan validasi waktu keluar
            'status' => 'required|in:hadir,izin,terlambat',
        ]);

        Absen::create($request->all());

        return redirect()->route('absens.index')->with('success', 'Absensi berhasil ditambahkan.');
    }

    // Menampilkan detail absensi
    public function show($id)
    {
        $absen = Absen::with('user')->findOrFail($id);
        return view('backend.pages.absens.show', compact('absen'));
    }

    // Menampilkan form untuk mengedit absensi
    public function edit($id)
    {
        $absen = Absen::findOrFail($id);
        $users = User::all();
        return view('backend.pages.absens.edit', compact('absen', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rfid' => 'required|string',
            'waktu_masuk' => 'required|date',
            'waktu_keluar' => 'nullable|date', // Tambahkan validasi waktu keluar
            'status' => 'required|in:hadir,izin,terlambat',
        ]);

        $absen = Absen::findOrFail($id);
        $absen->update($request->all());

        return redirect()->route('absens.index')->with('success', 'Absensi berhasil diperbarui.');
    }

    // Menghapus data absensi
    public function destroy($id)
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();

        return redirect()->route('absens.index')->with('success', 'Absensi berhasil dihapus.');
    }
}
