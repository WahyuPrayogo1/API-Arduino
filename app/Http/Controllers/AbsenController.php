<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AbsenController extends Controller
{
    public function index(Request $request)
    {
        $absens = Absen::with('user');

        // Jika ada filter tanggal, tambahkan kondisi untuk tanggal
        if ($request->has('tanggal') && $request->tanggal) {
            $absens->whereDate('waktu_masuk', $request->tanggal);
        }

        if ($request->ajax()) {
            return DataTables::of($absens)
                ->addColumn('waktu_keluar', function($row) {
                    return $row->waktu_keluar ? $row->waktu_keluar : 'Belum Keluar';
                })
                ->addColumn('status', function($row) {

                    $badgeClass = '';
                    switch ($row->status) {
                        case 'hadir':
                            $badgeClass = 'success';
                            break;
                        case 'izin':
                            $badgeClass = 'warning';
                            break;
                        case 'alpa':
                            $badgeClass = 'danger';
                            break;
                        default:
                            $badgeClass = 'secondary';
                            break;
                    }
                    // Mengembalikan badge dengan class yang sesuai
                    return '<span class=" text-white badge bg-' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('aksi', function($row) {
                    return view('backend.pages.absens.actions', compact('row'));
                })
                ->rawColumns(['status', 'aksi'])
                ->make(true);
        }


        return view('backend.pages.absens.index');
    }

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
            'waktu_keluar' => 'nullable|date',
            'status' => 'required|in:hadir,izin,alpa',
        ]);

        Absen::create($request->all());

        return redirect()->route('absens.index')->with('success', 'Absensi berhasil ditambahkan.');
    }


    public function show($id)
    {
        $absen = Absen::with('user')->findOrFail($id);
        return view('backend.pages.absens.show', compact('absen'));
    }

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
            'waktu_keluar' => 'nullable|date',
            'status' => 'required|in:hadir,izin,terlambat',
        ]);

        $absen = Absen::findOrFail($id);
        $absen->update($request->all());

        return redirect()->route('absens.index')->with('success', 'Absensi berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();

        return redirect()->route('absens.index')->with('success', 'Absensi berhasil dihapus.');
    }
}
