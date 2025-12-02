@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Master Indikator</h3>
                    <p class="text-subtitle text-muted">Daftar seluruh indikator rumah sakit</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Master Indikator</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Data Indikator</span>

                    <a href="{{ route('master-indikator.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus"></i> Tambah Indikator
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-striped" id="tableIndikator">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Unit</th>
                                <th>Target</th>
                                <th>Tipe</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($indikators as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>{{ $row->nama_indikator }}</td>

                                    <td>{{ $row->nama_unit ?? '-' }}</td>

                                    <td>{{ rtrim(rtrim($row->target_indikator, '0'), '.') }}%</td>

                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($row->tipe_indikator) }}</span>
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('j') }} -
                                        {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('j') }}
                                    </td>

                                    <td>
                                        @if($row->status_indikator == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('master-indikator.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('master-indikator.destroy', $row->id) }}" method="POST"
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