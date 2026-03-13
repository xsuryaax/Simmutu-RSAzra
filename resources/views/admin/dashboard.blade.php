@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Dashboard')

@section('page-title')
    <div class="dash-header">
        <div class="dash-header-left">
            <h3>Dashboard</h3>
        </div>
        <div class="dash-header-right">
            <form method="POST" action="/logout">
                <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong></span>
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-box-arrow-right"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>
@endsection

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
                        <h5 class="modal-title mb-1 text-white fw-bold" id="mdIndikatorTitle">Nama Indikator</h5>
                        <div class="d-flex gap-3 text-white-50 small" style="font-size: 0.85rem;">
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
                        <div class="row g-4 mb-4">
                            <!-- Left: Chart -->
                            <div class="col-lg-7">
                                <div class="bg-white p-4 h-100 rounded shadow-sm border d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-graph-up text-primary me-2"></i>Grafik Pencapaian Tahunan</h6>
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
                                                    <th class="align-middle fw-medium text-secondary" id="mdLabelNum">N</th>
                                                    <th class="align-middle fw-medium text-secondary" id="mdLabelDenom">D</th>
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
</style>
@endpush
@endsection
