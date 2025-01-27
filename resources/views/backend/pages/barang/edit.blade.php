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
                        Edit Barang
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl mt-5">
        <div class="row row-deck row-cards">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Barang</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="{{ $barang->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" name="kode" id="kode" value="{{ $barang->kode }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok Barang</label>
                            <input type="number" class="form-control" name="stok" id="stok" value="{{ $barang->stok }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Barang</label>
                            <input type="text" class="form-control" name="harga" id="harga" value="Rp. {{ number_format($barang->harga, 0, ',', '.') }}" required>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        const hargaInput = document.getElementById('harga');
        hargaInput.addEventListener('input', function (e) {
            let inputVal = e.target.value;
            inputVal = inputVal.replace(/[^0-9]/g, '');
            inputVal = new Intl.NumberFormat('id-ID').format(inputVal);
            e.target.value = 'Rp. ' + inputVal;
        });
    </script>
@endsection
