@extends('backend.master')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <h2 class="page-title">Tambah Penjualan</h2>
        </div>
    </div>

    <div class="container-xl mt-5">
        <div class="row row-deck row-cards">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('sales.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="barang_id">Barang</label>
                            <select name="barang_id" id="barang_id" class="form-control">
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}">
                                        {{ $barang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                            <input type="date" name="tanggal_penjualan" id="tanggal_penjualan" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input type="number" name="total_harga" id="total_harga" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Penjualan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menampilkan harga barang yang dipilih
        document.getElementById('barang_id').addEventListener('change', function() {
            var harga = this.options[this.selectedIndex].getAttribute('data-harga');
            document.getElementById('harga').value = harga; // Menampilkan harga
            calculateTotal(); // Menghitung total harga otomatis
        });

        // Menghitung total harga otomatis berdasarkan jumlah dan harga
        document.getElementById('jumlah').addEventListener('input', calculateTotal);

        function calculateTotal() {
            var jumlah = document.getElementById('jumlah').value;
            var harga = document.getElementById('harga').value;
            var totalHarga = jumlah * harga;
            document.getElementById('total_harga').value = totalHarga;
        }

        // Memastikan harga barang pertama kali terisi saat form pertama kali ditampilkan
        document.getElementById('barang_id').dispatchEvent(new Event('change'));
    </script>
@endsection
