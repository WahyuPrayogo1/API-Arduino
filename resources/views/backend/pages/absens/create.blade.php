@extends('backend.master')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Tambah Data
                    </div>
                    <h2 class="page-title">
                        Tambah Absensi Baru
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl mt-5">
        <div class="row row-deck row-cards">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Absensi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('absens.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama User</label>
                            <select class="form-select" name="user_id" id="user_id" required>
                                <option value="" disabled selected>Pilih User</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rfid" class="form-label">RFID</label>
                            <input type="text" class="form-control" name="rfid" id="rfid" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
                            <input type="datetime-local" class="form-control" name="waktu_masuk" id="waktu_masuk" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="alpa">Alpa</option>
                            </select>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('absens.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
