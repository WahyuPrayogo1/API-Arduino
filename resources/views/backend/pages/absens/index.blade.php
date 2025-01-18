@extends('backend.master')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Dashboard
                    </div>
                    <h2 class="page-title">
                        Sistem Absensi Karyawan
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('absens.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Absensi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl mt-5">
        <div class="row row-deck row-cards">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Absensi</h3>
                </div>
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        @if ($absens->isEmpty())
                            <div class="alert alert-warning text-center">
                                <strong>Tidak ada data absensi.</strong> Silakan tambahkan data absensi baru.
                            </div>
                        @else
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama User</th>
                                        <th>RFID</th>
                                        <th>Waktu Masuk</th>
                                        <th>Waktu Keluar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absens as $absen)
                                        <tr>
                                            <td>{{ $absen->id }}</td>
                                            <td>{{ $absen->user->name }}</td>
                                            <td>{{ $absen->rfid }}</td>
                                            <td>{{ $absen->waktu_masuk }}</td>
                                            <td>{{ $absen->waktu_keluar ?? 'Belum keluar' }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $absen->status == 'hadir' ? 'success' : ($absen->status == 'izin' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($absen->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('absens.edit', $absen->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete({{ $absen->id }})">
                                                    Hapus
                                                </button>
                                                <form id="delete-form-{{ $absen->id }}"
                                                    action="{{ route('absens.destroy', $absen->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
