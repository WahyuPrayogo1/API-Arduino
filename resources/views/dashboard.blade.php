@extends('backend.master')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            Dashboard
          </div>
          <h2 class="page-title">
            Enterprise Resource Planning (ERP)🤷‍♂️
          </h2>
        </div>
      </div>
    </div>
  </div>
<div class="container-xl mt-5">
    <div class="row row-deck row-cards">
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Karyawan</div>
            </div>
            <div class="h1 mb-3">{{$totalUsers}}</div>
            <div class="d-flex mb-2">
                <div>Sudah Absen Hari Ini</div>
                <div class="ms-auto">
                    <span class="text-green d-inline-flex align-items-center lh-1">
                        {{ number_format($percentage, 0) }}%
                    </span>
                </div>
            </div>
            <div class="progress progress-sm">
                <div
                    class="progress-bar bg-primary"
                    style="width: {{ $percentage }}%"
                    role="progressbar"
                    aria-valuenow="{{ $percentage }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    aria-label="{{ number_format($percentage, 0) }}% Complete">
                    <span class="visually-hidden">{{ number_format($percentage, 0) }}% Complete</span>
                </div>
            </div>


          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Total Barang Masuk</div>
                  </div>
                  <div class="h1 mb-3">{{$totalBarangMasuk}}</div>
            </div>

        </div>

      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Total Barang</div>
            </div>
            <div class="d-flex align-items-baseline">
              <div class="h1 mb-3 me-2">{{$totalBarang}}</div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Penjualan</div>
            </div>
            <div class="d-flex align-items-baseline">
              <div class="h1 mb-3 me-2">2,986</div>
              <div class="me-auto">
                <span class="text-green d-inline-flex align-items-center lh-1">
                  4% <!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                </span>
              </div>
            </div>
        
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
