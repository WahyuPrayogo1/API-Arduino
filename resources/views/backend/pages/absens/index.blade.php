@extends('backend.master')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="{{asset('backend/css/')}}">
<style>


.dataTables_wrapper .dataTable tbody td {
    padding-top: 15px;
    padding-bottom: 15px;
}


.dataTables_wrapper .dataTable thead th {
    padding-top: 15px;
    padding-bottom: 15px;
}


    .dataTables_wrapper .dataTables_paginate {
        margin-top: 20px;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 5px;
    }


    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #007bff;
        color: white;
    }


    .dataTables_wrapper .dataTables_info {
        margin-top: 10px;
    }

    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 20px;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        color: white;
    }

    .table th, .table td {
        color: white;
    }

     .table {
        background-color: transparent;
    }
   .table thead {
        background-color: #f30000;
    }

   .table tbody tr:nth-child(odd) {
        background-color: rgba(255, 10, 10, 0);
        border-bottom: 2px solid rgba(219, 219, 219, 0.192);
    }

    .table tbody tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0);
        border-bottom: 2px solid rgba(219, 219, 219, 0.192);
    }

    .dataTables_paginate a {
        color: rgba(255, 255, 255, 0);
        border: 1px solid rgb(214, 26, 26);
        padding: 5px 10px;
    }

    .dataTables_paginate a:hover {
        background-color: #555;
    }
</style>


<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    Dashboard
                </div>
                <h2 class="page-title pb-2">
                    Sistem Absensi Karyawan
                </h2>
                <small style="color: rgb(255, 0, 0);" >Fitur Sudah Bisa integrasi dengan Mikrokontroller Menggunakan RFID Kartu</small>
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

                <div class="d-flex ms-auto">
                    <form action="{{ route('absens.index') }}" method="GET" class="d-flex">
                        <div class="input-group">
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control" placeholder="Pilih Tanggal" onchange="this.form.submit()">
                        </div>
                    </form>
                    @if(request('tanggal'))
                        <a href="{{ route('absens.index') }}" class="btn btn-secondary ms-2">Reset</a>
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div id="table-default" class="table-responsive">
                    <table id="absensiTable" class="table">
                        <thead>
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
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#absensiTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('absens.index') }}',
                    data: function(d) {
                        d.tanggal = $('input[name="tanggal"]').val(); // Mengirim data filter tanggal jika ada
                    }
                },
                language: {
            "emptyTable": "Tidak ada data yang tersedia",  // Ganti kata-kata di sini
            "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri", // Mengubah teks info
            "infoEmpty": "Menampilkan 0 hingga 0 dari 0 entri", // Ganti jika data kosong
            "infoFiltered": "(terfilter dari _MAX_ total entri)",
            "paginate": {
                "previous": "Sebelumnya", // Mengubah teks tombol sebelumnya
                "next": "Berikutnya" // Mengubah teks tombol berikutnya
            }
        },
                columns: [
                    { data: 'id' },
                    { data: 'user.name' },
                    { data: 'rfid' },
                    {
                data: 'waktu_masuk',
                render: function(data) {
                    // Gunakan moment.js untuk memformat waktu
                    return moment(data).format('DD-MM-YYYY HH:mm:ss');
                }
            },
                    { data: 'waktu_keluar' },
                    { data: 'status', orderable: false, searchable: false },
                    { data: 'aksi', orderable: false, searchable: false }
                ]
            });

            // Menambahkan event listener untuk form filter tanggal
            $('input[name="tanggal"]').change(function() {
                table.draw();
            });
        });
    </script>

@endsection
