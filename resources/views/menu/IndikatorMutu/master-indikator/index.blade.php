@extends('layouts.app')

@section('title', 'Master Indikator')

@section('title', 'Master Indikator')
@section('subtitle', 'Halaman pengelolaan data target dan realisasi indikator mutu')

@section('content')
    <section class="section">
        {{-- Filter Section --}}
        <div class="table-filter-section mb-4">
            <div class="row align-items-end">
                <div class="col">
                    <form method="GET" action="{{ route('master-indikator.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label class="filter-label">Tahun Periode</label>
                            <select name="periode_id" class="form-select" onchange="this.form.submit()">
                                @foreach ($periodes as $p)
                                    <option value="{{ $p->id }}" {{ $periodeId == $p->id ? 'selected' : '' }}>
                                        {{ $p->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @php $isAdminMutu = in_array(auth()->user()->unit_id, [1, 2]); @endphp
                        @if ($isAdminMutu)
                            <div class="col-md-4">
                                <label class="filter-label">Unit / Organisasi</label>
                                <select name="unit_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">-- Semua Unit --</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </form>
                </div>
                <div class="col-auto pb-2">
                    <div id="table-legend-placeholder"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 table-column-grow">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        {{-- Integrated Actions for DataTable --}}
                        <div id="table-actions-content" class="d-none">
                            <a href="{{ route('master-indikator.create') }}" class="btn btn-primary shadow-sm btn-sm">
                                <i class="bi bi-plus-lg"></i> Tambah Data
                            </a>
                        </div>

                        {{-- Integrated Legend for DataTable --}}
                        <div id="table-legend-content" class="d-none">
                            <div class="d-flex flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger me-2" style="width: 12px; height: 12px; border-radius: 4px;">&nbsp;</span>
                                    <small class="text-muted fw-medium">Nasional</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2" style="width: 12px; height: 12px; border-radius: 4px;">&nbsp;</span>
                                    <small class="text-muted fw-medium">Prioritas RS</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light border me-2" style="width: 12px; height: 12px; border-radius: 4px;">&nbsp;</span>
                                    <small class="text-muted fw-medium">Prioritas Unit</small>
                                </div>
                            </div>
                        </div>


                        <table class="table table-striped" id="table1" style="width: 100%; min-width: 1000px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th style="min-width: 350px;">INDIKATOR</th>
                                        @if ($isAdminMutu)
                                            <th class="text-center">UNIT</th>
                                        @endif
                                        <th class="text-center">TARGET</th>
                                        <th class="text-center">KETERANGAN</th>
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($indikators as $i => $row)
                                        @php
                                            $colColor = '';
                                            $kategori = $row->kategori_indikator ?? '';
                                            if (str_contains($kategori, 'Nasional')) {
                                                $colColor = 'table-danger';
                                            } elseif (str_contains($kategori, 'Prioritas RS')) {
                                                $colColor = 'table-success';
                                            } elseif (str_contains($kategori, 'Prioritas Unit')) {
                                                $colColor = 'table-secondary';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td class="{{ $colColor }} fw-semibold">{{ $row->nama_indikator }}</td>
                                            @if ($isAdminMutu)
                                                <td class="text-center">{{ $row->nama_unit ?? '-' }}</td>
                                            @endif

                                            <td class="text-center">
                                                @php
                                                    $arah = '';
                                                    if ($row->arah_target == 'lebih_besar') {
                                                        $arah = '≥ ';
                                                    } elseif ($row->arah_target == 'lebih_kecil') {
                                                        $arah = '≤ ';
                                                    }
                                                @endphp

                                                @if($row->arah_target == 'range')
                                                    {{ rtrim(rtrim($row->target_min, '0'), '.') }} -
                                                    {{ rtrim(rtrim($row->target_max, '0'), '.') }} %
                                                @else
                                                    {{ $arah }}{{ rtrim(rtrim($row->target_indikator, '0'), '.') }} %
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ !empty($row->keterangan) 
                                                    ? $row->keterangan 
                                                    : 'Persentase (Numerator / Denominator)' }}
                                            </td>

                                            <td class="text-center">
                                                @if($row->status_indikator == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Non-Aktif</span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('master-indikator.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form action="{{ route('master-indikator.destroy', $row->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus indikator ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>

                                                @if($periodeAktif && $periodeDipilih && $periodeDipilih->id != $periodeAktif->id && is_null($row->sudah_di_periode_aktif))
                                                    <form action="{{ route('indikator.active', $row->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm"
                                                            onclick="return confirm('Masukkan indikator ini ke periode aktif?')"
                                                            title="Aktifkan ke periode aktif">
                                                            <i class="bi bi-plus-circle"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection