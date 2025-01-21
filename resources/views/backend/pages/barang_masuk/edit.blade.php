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
                        Edit Barang Masuk
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl mt-5">
        <div class="row row-deck row-cards">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Barang Masuk</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang-masuk.update', $barangMasuk->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="barang_id" class="form-label">Nama Barang</label>
                            <select class="form-select" name="barang_id" id="barang_id" required>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}"
                                        {{ $barangMasuk->barang_id == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok Barang Masuk</label>
                            <input type="number" class="form-control" name="jumlah" id="jumlah" value="{{ $barangMasuk->jumlah }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Barang</label>
                            <input type="text" class="form-control" name="harga" id="harga" value="Rp. {{ number_format($barangMasuk->harga, 0, ',', '.') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <!-- Pastikan menggunakan format yang benar -->
                            <input type="date" class="form-control" name="tanggal_masuk" id="tanggal_masuk" value="{{ \Carbon\Carbon::createFromFormat('d-m-Y', $formattedTanggalMasuk)->format('Y-m-d') }}" required>

                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('barang-masuk.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Format harga menjadi format rupiah saat input
        const hargaInput = document.getElementById('harga');

        // Fungsi untuk menghapus simbol Rp dan memformat harga
        hargaInput.addEventListener('input', function (e) {
            let inputVal = e.target.value;

            // Menghapus simbol 'Rp.' dan karakter selain angka
            inputVal = inputVal.replace(/[^0-9]/g, '');

            // Format angka menjadi format rupiah
            inputVal = new Intl.NumberFormat('id-ID').format(inputVal);

            // Menambahkan 'Rp.' di depan angka yang telah diformat
            e.target.value = 'Rp. ' + inputVal;
        });

        // Sebelum form disubmit, kita pastikan harga hanya mengirimkan angka tanpa simbol 'Rp.'
        document.querySelector('form').addEventListener('submit', function() {
            let harga = hargaInput.value.replace(/[^0-9]/g, ''); // Menghapus simbol 'Rp.' dan karakter selain angka
            hargaInput.value = harga; // Mengupdate input harga dengan angka murni
        });
    </script>
@endsection
