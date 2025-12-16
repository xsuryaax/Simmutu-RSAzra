@extends('layouts.app')

@section('title', 'Default Layout')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Interpretasi Data</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola interpretasi data dalam sistem.
            </p>
        </div>
        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn btn-primary logout-btn">
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
                            Interpretasi Data
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Interpretasi Data</h5>

                <a href="{{ route('interpretasi-data.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Interpretasi Data
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive table-dark">
                    <table class="table table-striped" id="tableIndikator">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($interpretasiData as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>{{ $row->nama_interpretasi_data }}</td>
                                    <td>
                                        <a href="{{ route('interpretasi-data.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('interpretasi-data.destroy', $row->id) }}" method="POST"
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
