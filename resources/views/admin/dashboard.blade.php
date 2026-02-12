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
                {{-- ===== CHART ADMIN ===== --}}
                @if (in_array($roleId, [1, 2]))
                    @include('admin.partials.cards')

                    {{-- Prioritas Unit --}}
                    @include('admin.partials.unit-chart')

                    {{-- Indikator Mutu Nasional --}}
                    @include('admin.partials.imn-chart')

                    {{-- Indikator Mutu Prioritas RS --}}
                    @include('admin.partials.imprs-chart')
                @else
                    {{-- Unit Chart --}}
                    @include('admin.partials.users-view')
                @endif

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
                        <thead class="table-light sticky-top">
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
                        <thead class="table-light sticky-top">
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
@endsection
