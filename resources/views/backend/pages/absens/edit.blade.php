@extends('backend.master')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Edit Data
                    </div>
                    <h2 class="page-title">
                        Edit Absensi
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl mt-5">
        <div class="row row-deck row-cards">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Absensi</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('absens.update', $absen->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama User</label>
                            <select class="form-select" name="user_id" id="user_id" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $absen->user_id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="rfid" class="form-label">RFID</label>
                            <input type="text" class="form-control" name="rfid" id="rfid" value="{{ $absen->rfid }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
                            <input type="datetime-local" class="form-control" name="waktu_masuk" id="waktu_masuk" value="{{ $absen->waktu_masuk }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status" required>
                                <option value="hadir" {{ $absen->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ $absen->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="alpa" {{ $absen->status == 'alpa' ? 'selected' : '' }}>Alpa</option>
                            </select>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('absens.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
