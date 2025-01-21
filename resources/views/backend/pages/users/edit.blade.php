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
                        Edit User
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl mt-5">
        <div class="row row-deck row-cards">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit User</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama User</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="mb-3">
                            <label for="rfid" class="form-label">RFID</label>
                            <input type="text" class="form-control" name="rfid" id="rfid" value="{{ $user->rfid }}" required>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
