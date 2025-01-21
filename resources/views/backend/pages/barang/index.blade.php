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
                        <a href="{{ route('barang.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Barang
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
                    <h3 class="card-title">Daftar Barang</h3>
                </div>
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        @if ($barangs->isEmpty())
                            <div class="alert alert-warning text-center">
                                <strong>Tidak ada data barang.</strong> Silakan tambahkan data barang baru.
                            </div>
                        @else
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Barang</th>
                                        <th>Kode</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barangs as $barang)
                                        <tr>
                                            <td>{{ $barang->id }}</td>
                                            <td>{{ $barang->nama }}</td>
                                            <td>{{ $barang->kode }}</td>
                                            <td>{{ $barang->stok }}</td>
                                            <td>{{ 'Rp. ' . number_format($barang->harga, 0, ',', '.') }}</td>

                                            <td>
                                                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $barang->id }})">
                                                    Hapus
                                                </button>
                                                <form id="delete-form-{{ $barang->id }}" action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display: none;">
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
