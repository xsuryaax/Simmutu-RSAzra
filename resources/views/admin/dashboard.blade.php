@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan capaian indikator mutu rumah sakit')

{{-- Bagian Konten Utama --}}
@section('content')
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                {{-- ===== CHART UNIFIED ===== --}}
                @if (in_array($roleId, [1, 2]))
                    @include('admin.partials.cards')
                @else
                    {{-- Statistik Ringkas Unit --}}
                    @include('admin.partials.users-stats')
                @endif

                {{-- Chart terpadu dengan filter indikator (IMN / IMPRS / Prioritas Unit) --}}
                @include('admin.partials.combined-chart')

            </div>

        </section>
    </div>

    {{-- modal untuk card --}}
    <div class="modal fade" id="modalSudahIsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="text-white">Daftar Indikator Sudah Terisi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th style="width: 30%;">Nama Unit</th>
                                <th>Indikator Sudah Terisi</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unitsSudah as $unit)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $unit->nama_unit }}</td>
                                    <td>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($unit->list_sudah as $ind)
                                                <li>{{ $ind }} </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>
                                        <div class="fw-normal text-primary">
                                            {{ count($unit->list_sudah) }} / {{ $unit->total_indikator }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBelumIsi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="text-white">Daftar Indikator Belum Terisi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="sticky-top">
                            <tr>
                                <th style="width: 30%;">Nama Unit</th>
                                <th>Indikator Belum Terisi</th>
                                <th>Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unitsBelum as $unit)
                                <tr>
                                    <td class="fw-bold text-danger">{{ $unit->nama_unit }}</td>
                                    <td>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($unit->list_belum as $ind)
                                                <li>{{ $ind }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="fw-bold text-danger">
                                        <div class="fw-normal">{{ count($unit->list_sudah) }} /
                                            {{ count($unit->list_sudah) + count($unit->list_belum) }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDetailChart" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-bottom-0 pb-3" style="border-radius: .5rem .5rem 0 0;">
                    <div>
                        <h5 class="modal-title mb-1 fw-bold" id="mdIndikatorTitle" style="color:#fff;">Nama Indikator</h5>
                        <div class="d-flex gap-3 small" style="font-size: 0.85rem; color: rgba(255,255,255,0.9);">
                            <span id="mdIndikatorUnit"><i class="bi bi-hospital me-1"></i> Unit</span>
                            <span id="mdIndikatorKategori"><i class="bi bi-tags me-1"></i> Kategori</span>
                            <span id="mdIndikatorStandar"><i class="bi bi-bullseye me-1"></i> Standar</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body p-0 bg-light">
                    <!-- Modal Loader -->
                    <div id="mdLoader" class="d-flex justify-content-center align-items-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-3 fw-semibold text-secondary">Sedang memuat rincian data...</span>
                    </div>

                    <!-- Modal Content -->
                    <div id="mdContent" class="d-none p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <p class="mb-0 text-muted small">Indikator yang dipilih</p>
                                <h6 class="fw-bold mb-0 text-dark" id="mdIndikatorTitleBody">—</h6>
                            </div>
                            <div class="btn-group btn-group-sm shadow-sm" role="group" id="mdQuarterGroup">
                                <button class="btn btn-primary active md-btn-quarter" data-q="Tahun">All</button>
                                <button class="btn btn-light md-btn-quarter border" data-q="S1">S1</button>
                                <button class="btn btn-light md-btn-quarter border" data-q="S2">S2</button>
                                <button class="btn btn-light md-btn-quarter border" data-q="Q1">Q1</button>
                                <button class="btn btn-light md-btn-quarter border" data-q="Q2">Q2</button>
                                <button class="btn btn-light md-btn-quarter border" data-q="Q3">Q3</button>
                                <button class="btn btn-light md-btn-quarter border" data-q="Q4">Q4</button>
                            </div>
                        </div>
                        <div class="row g-4 mb-4">
                            <!-- Left: Chart -->
                            <div class="col-lg-7">
                                <div class="bg-white p-4 h-100 rounded shadow-sm border d-flex flex-column">
                                    <div class="d-flex justify-content-end align-items-center mb-3">
                                        <div class="chart-legend d-flex gap-3 small fw-medium text-muted">
                                            <span><span class="legend-dot pencapaian" style="background:#e63757"></span> Pencapaian</span>
                                            <span><span class="legend-dot standar" style="border: 2px dashed #2c7be5"></span> Standar</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1" style="position:relative; min-height: 250px;">
                                        <canvas id="mdChartCanvas"></canvas>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right: Table N,D,% -->
                            <div class="col-lg-5">
                                <div class="bg-white p-4 h-100 rounded shadow-sm border">
                                    <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-table text-primary me-2"></i>Rincian Nilai Bulanan</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm text-center mb-0 align-middle" style="font-size: 0.85rem;">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="align-middle" style="width: 15%">Bulan</th>
                                                    <th class="align-middle fw-semibold" id="mdLabelNum">N</th>
                                                    <th class="align-middle fw-semibold" id="mdLabelDenom">D</th>
                                                    <th class="align-middle" style="width: 20%">Pencapaian</th>
                                                </tr>
                                            </thead>
                                            <tbody id="mdTbodyBulanan">
                                                <!-- Injected via JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom: PDSA -->
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="bg-white p-4 rounded shadow-sm border">
                                    <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-clipboard-check text-primary me-2"></i>Status PDSA</h6>
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-sm mb-0 align-middle" style="font-size: 0.85rem;">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th style="width: 10%">Quarter</th>
                                                    <th style="width: 12%">Status</th>
                                                    <th class="text-start" style="width: 20%">Plan</th>
                                                    <th class="text-start" style="width: 20%">Do</th>
                                                    <th class="text-start" style="width: 20%">Study</th>
                                                    <th class="text-start" style="width: 20%">Act</th>
                                                </tr>
                                            </thead>
                                            <tbody id="mdTbodyPdsa">
                                                <!-- Injected via JS -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('css')
<style>
    /* Custom hover effect for the PDF Download button */
    .btn-pdf-export {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
        color: white !important;
    }
    .btn-pdf-export:hover,
    .btn-pdf-export:focus,
    .btn-pdf-export.show {
        background-color: #e9ecef !important;
        border-color: #e9ecef !important;
        color: #495057 !important;
    }

    /* --- Detail Modal: Dark Mode Only Overrides ---
       These rules ONLY fire when [data-bs-theme="dark"] is active.
       Light mode is completely untouched. */
    [data-bs-theme="dark"] #modalDetailChart .modal-body.bg-light,
    [data-bs-theme="dark"] #modalDetailChart .modal-body {
        background-color: #1e2530 !important;
    }
    [data-bs-theme="dark"] #modalDetailChart .bg-white {
        background-color: #2b3240 !important;
        border-color: #3d4a5c !important;
    }
    [data-bs-theme="dark"] #modalDetailChart .text-dark {
        color: #e2e8f0 !important;
    }
    [data-bs-theme="dark"] #modalDetailChart .text-muted {
        color: #94a3b8 !important;
    }
    [data-bs-theme="dark"] #modalDetailChart .table-light th {
        background-color: #374151 !important;
        color: #e2e8f0 !important;
        border-color: #4b5563 !important;
    }
    [data-bs-theme="dark"] #modalDetailChart .table {
        --bs-table-color: #e2e8f0;
        --bs-table-bg: #2b3240;
        --bs-table-border-color: #4b5563;
        --bs-table-striped-bg: #323a4c;
        --bs-table-hover-bg: #3a4357;
    }
    [data-bs-theme="dark"] #mdTbodyBulanan td.fw-bold {
        background-color: #374151 !important;
        color: #e2e8f0 !important;
    }
    [data-bs-theme="dark"] #mdTbodyBulanan tr.table-secondary td {
        background-color: #374151 !important;
        color: #e2e8f0 !important;
        border-color: #4b5563 !important;
        font-weight: 600 !important;
    }
    /* Quarter buttons (Q1-Q4, inactive) — dark mode only */
    [data-bs-theme="dark"] #mdQuarterGroup .btn-light {
        background-color: #374151 !important;
        color: #e2e8f0 !important;
        border-color: #4b5563 !important;
    }
    [data-bs-theme="dark"] #mdQuarterGroup .btn-light:hover {
        background-color: #4b5563 !important;
        color: #fff !important;
    }
    /* Section headings & labels */
    [data-bs-theme="dark"] #mdContent .text-dark {
        color: #e2e8f0 !important;
    }
</style>
@endpush
@endsection
