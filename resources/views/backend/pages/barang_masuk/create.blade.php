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
                        Tambah Barang Masuk
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl mt-5">
        <div class="row row-deck row-cards">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Barang Masuk</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang-masuk.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">Nama Barang</label>
                            <select name="barang_id" id="barang_id" class="form-control" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah Barang Masuk</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga per Barang</label>
                            <input type="text" class="form-control" name="harga" id="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" required>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk format input harga menjadi rupiah
        const formatRupiah = (angka, prefix = 'Rp ') => {
            var number_string = angka.replace(/[^,\d]/g, '').toString();
            var split = number_string.split(',');
            var remainder = split[0].length % 3;
            var rupiah = split[0].substr(0, remainder);
            var thousand = split[0].substr(remainder).match(/\d{3}/gi);

            if (thousand) {
                var separator = remainder ? '.' : '';
                rupiah += separator + thousand.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix + rupiah;
        }

        // Menambahkan event listener untuk menangani input harga
        document.getElementById('harga').addEventListener('input', function (e) {
            let harga = e.target.value;
            e.target.value = formatRupiah(harga);
        });
    </script>
@endsection
