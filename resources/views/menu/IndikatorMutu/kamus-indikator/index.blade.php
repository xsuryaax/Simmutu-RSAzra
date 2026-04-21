@extends('layouts.app')

@section('title', 'Profil Indikator')
@section('subtitle', 'Detail pengukuran dan definisi operasional indikator mutu')

@section('content')
    <section class="section">
        {{-- Filter & Legend Section --}}
        <div class="table-filter-section mb-4">
            <div class="row align-items-end">
                <div class="col">
                    @if ($isAdminMutu)
                        <form method="GET" action="{{ route('kamus-indikator.index') }}" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="filter-label">Unit / Organisasi</label>
                                <select name="unit_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">-- Semua Unit --</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" {{ $unitId == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="col-auto pb-2">
                    <div id="table-legend-placeholder"></div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                {{-- Unified Table Controls --}}
                <div id="table-actions-content" class="d-none">
                    <a href="{{ route('kamus-indikator.create') }}" class="btn btn-primary shadow-sm btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah Data
                    </a>
                </div>

                {{-- This legend will be moved into the DataTable header by JS --}}
                <div id="table-legend-content" class="d-none">
                    <div class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger me-2" style="width: 15px; height: 15px; border-radius: 4px;">&nbsp;</span>
                            <small class="text-muted fw-medium">Nasional</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-2" style="width: 15px; height: 15px; border-radius: 4px;">&nbsp;</span>
                            <small class="text-muted fw-medium">Prioritas RS</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-light border me-2" style="width: 15px; height: 15px; border-radius: 4px;">&nbsp;</span>
                            <small class="text-muted fw-medium">Prioritas Unit</small>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th style="min-width: 350px;">Indikator</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Kategori Indikator</th>
                                <th class="text-center">Dimensi Mutu</th>
                                <th class="text-center">Periode Pengumpulan</th>
                                <th class="text-center">Periode Analisis</th>
                                <th class="text-center">Penyajian Data</th>
                                <th class="text-center">Penanggung Jawab</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mutu as $m)
                                @php
                                    $colColor = '';
                                    $kategori = $m->kategori_indikator ?? '';

                                    // Hierarki Warna: Nasional (Red) > Prioritas RS (Green) > Prioritas Unit (Grey)
                                    if (str_contains($kategori, 'Nasional')) {
                                        $colColor = 'table-danger';
                                    } elseif (str_contains($kategori, 'Prioritas RS')) {
                                        $colColor = 'table-success';
                                    } elseif (str_contains($kategori, 'Prioritas Unit')) {
                                        $colColor = 'table-secondary';
                                    }
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="{{ $colColor }} fw-semibold">{{ $m->nama_indikator }}</td>
                                    <td class="text-center">{{ $m->nama_unit }}</td>
                                    <td class="text-center">{{ $m->kategori_indikator }}</td>
                                    <td class="text-center">{{ $m->nama_dimensi_mutu }}</td>
                                    <td class="text-center">{{ $m->nama_periode_pengumpulan_data }}</td>
                                    <td class="text-center">{{ $m->nama_periode_analisis_data }}</td>
                                    <td class="text-center">{{ $m->nama_penyajian_data }}</td>
                                    <td class="text-center">{{ $m->penanggung_jawab }}</td>
                                    <td class="text-center">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('export.profile', $m->id) }}" class="btn btn-info btn-sm"
                                                target="_blank">
                                                <i class="bi bi-download"></i>
                                            </a>

                                            <a href="{{ route('kamus-indikator.edit', $m->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('kamus-indikator.destroy', $m->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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
