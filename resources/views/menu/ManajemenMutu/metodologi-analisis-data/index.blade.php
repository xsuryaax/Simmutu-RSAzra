@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Metodologi Analisis Data</h3>
                    <p class="text-subtitle text-muted">
                       Metodologi analisis data rumah sakit Azra
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <div class="justify-content-end d-flex">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-box-arrow-right"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                    <div>
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Metodologi Analisis Data
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
@endsection

    @section('content')
        <section class="section">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Metodologi Analisis Data</span>

                    <a href="{{ route('metodologi-analisis-data.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus"></i> Tambah Metodologi Analisis Data
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="tableIndikator">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($metodologiAnalisisData as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>{{ $row->nama_metodologi_analisis_data }}</td>
                                    <td>
                                        <a href="{{ route('metodologi-analisis-data.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('metodologi-analisis-data.destroy', $row->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus data ini?')">
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
            let indikatorTable = document.querySelector('#tableIndikator');
            let dataIndikator = new simpleDatatables.DataTable(indikatorTable);
        </script>
    @endpush