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
                        Sistem Manajemen Gudang
                    </h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('barang-masuk.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Barang Masuk
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
                    <h3 class="card-title">Daftar Barang Masuk</h3>
                </div>
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        @if ($barangMasuks->isEmpty())
                            <div class="alert alert-warning text-center">
                                <strong>Tidak ada data barang masuk.</strong> Silakan tambahkan data barang masuk baru.
                            </div>
                        @else
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Barang</th>
                                        <th>Kode Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga per Unit</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangMasuks as $barangMasuk)
                                        <tr>
                                            <td>{{ $barangMasuk->id }}</td>
                                            <td>{{ $barangMasuk->barang->nama }}</td> <!-- Menampilkan nama barang dari relasi -->
                                            <td>{{ $barangMasuk->barang->kode }}</td> <!-- Menampilkan kode barang dari relasi -->
                                            <td>{{ $barangMasuk->jumlah }}</td>
                                            <td>{{ 'Rp. ' . number_format($barangMasuk->harga, 0, ',', '.') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($barangMasuk->tanggal_masuk)->format('d-m-Y') }}</td>

                                            <td>
                                                <a href="{{ route('barang-masuk.edit', $barangMasuk->id) }}" class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $barangMasuk->id }})">
                                                    Hapus
                                                </button>
                                                <form id="delete-form-{{ $barangMasuk->id }}" action="{{ route('barang-masuk.destroy', $barangMasuk->id) }}" method="POST" style="display: none;">
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
