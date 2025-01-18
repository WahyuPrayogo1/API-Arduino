@extends('layouts.app')

@section('content')
    <h1>Detail Absensi</h1>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $absen->id }}</td>
        </tr>
        <tr>
            <th>Nama User</th>
            <td>{{ $absen->user->name }}</td>
        </tr>
        <tr>
            <th>RFID</th>
            <td>{{ $absen->rfid }}</td>
        </tr>
        <tr>
            <th>Waktu Masuk</th>
            <td>{{ $absen->waktu_masuk }}</td>
        </tr>
        <tr>
            <th>Waktu Keluar</th>
            <td>{{ $absen->waktu_keluar ?? 'Belum keluar' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $absen->status }}</td>
        </tr>
        <tr>
            <th>Dibuat Pada</th>
            <td>{{ $absen->created_at }}</td>
        </tr>
        <tr>
            <th>Diperbarui Pada</th>
            <td>{{ $absen->updated_at }}</td>
        </tr>
    </table>

    <a href="{{ route('absens.index') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('absens.edit', $absen->id) }}" class="btn btn-warning">Edit</a>

    <form action="{{ route('absens.destroy', $absen->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
    </form>
@endsection
