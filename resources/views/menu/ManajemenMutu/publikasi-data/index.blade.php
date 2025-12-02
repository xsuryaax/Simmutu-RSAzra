@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Publikasi Data</h3>
                    <p class="text-subtitle text-muted">Daftar seluruh publikasi data</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Publikasi Data</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Publikasi Data</span>

                    <a href="{{ route('publikasi-data.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus"></i> Tambah Publikasi Data
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
                            @foreach($publikasiData as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>{{ $row->nama_publikasi_data }}</td>
                                    <td>
                                        <a href="{{ route('publikasi-data.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('publikasi-data.destroy', $row->id) }}" method="POST"
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
        let indikatorTable = document.querySelector('#tableIndikator');
        let dataIndikator = new simpleDatatables.DataTable(indikatorTable);
    </script>
@endpush