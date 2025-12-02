@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Unit</h3>
                    <p class="text-subtitle text-muted">Daftar seluruh unit yang tersedia</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manajemen Unit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4 col-12">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <!-- KIRI: Teks -->
                        <div>
                            <h6 class="text-muted mb-1">Total Unit</h6>
                            <h2 class="fw-bold mb-0">{{ $totalUnit }}</h2>
                        </div>

                        <!-- KANAN: Icon -->
                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-building" style="font-size: 24px;"></i>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-md-4 col-12">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <!-- KIRI -->
                        <div>
                            <h6 class="text-success mb-1">Unit Aktif</h6>
                            <h2 class="fw-bold text-success mb-0">{{ $unitAktif }}</h2>
                        </div>

                        <!-- KANAN: ICON CEKLIS -->
                        <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-check-circle" style="font-size: 24px;"></i>
                        </div>

                    </div>
                </div>
            </div>


            <div class="col-md-4 col-12">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <!-- KIRI -->
                        <div>
                            <h6 class="text-danger mb-1">Unit Non-Aktif</h6>
                            <h2 class="fw-bold text-danger mb-0">{{ $unitNonAktif }}</h2>
                        </div>

                        <!-- KANAN: ICON SILANG -->
                        <div class="rounded-circle bg-danger text-white d-flex justify-content-center align-items-center"
                            style="width: 50px; height: 50px;">
                            <i class="bi bi-x-circle" style="font-size: 24px;"></i>
                        </div>

                    </div>
                </div>
            </div>


        </div>

        <section class="section">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Data Unit</span>

                    <a href="{{ route('manajemen-unit.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus"></i> Tambah Unit
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Unit</th>
                                <th>Nama Unit</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($units as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kode_unit }}</td>
                                    <td>{{ $item->nama_unit }}</td>
                                    <td>{{ $item->deskripsi_unit }}</td>
                                    <td>
                                        @if ($item->status == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('manajemen-unit.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('manajemen-unit.destroy', $item->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus unit ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <style>
        .dataTable-wrapper .dataTable-pagination a {
            padding: 3px 6px !important;
            font-size: 11px !important;
            min-width: 28px !important;
        }

        .dataTable-wrapper .dataTable-selector {
            width: 60px !important;
            padding: 4px 6px !important;
            font-size: 12px !important;
        }

        .dataTable-wrapper .dataTable-input {
            padding: 4px 8px !important;
            font-size: 12px !important;
            height: 32px !important;
        }

        .dataTable-top {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            flex-wrap: wrap;
            gap: 10px;
        }

        .dataTable-dropdown,
        .dataTable-search {
            margin: 0 !important;
        }
    </style>

    <script>
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
@endpush