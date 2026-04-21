@extends('layouts.app')

@section('title', 'Master SPM')
@section('subtitle', 'Pengelolaan daftar Standar Pelayanan Minimal RS Azra')

@section('title', 'Master SPM')

@section('content')
    <section class="section">
        {{-- Filter Section --}}
        <div class="table-filter-section mb-4">
            <form method="GET" action="{{ route('master-spm.index') }}" class="row g-3 align-items-end">
                @php $isAdminMutu = in_array(auth()->user()->unit_id, [1, 2]); @endphp
                @if ($isAdminMutu)
                    <div class="col-md-4">
                        <label class="filter-label">Unit / Organisasi</label>
                        <select name="unit_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Unit --</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="col-md-3">
                    <label class="filter-label">Periode</label>
                    <select name="periode_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Semua Periode --</option>
                        @foreach ($periodes as $p)
                            <option value="{{ $p->id }}"
                                {{ request('periode_id') == $p->id || (!request('periode_id') && $periodeAktif && $periodeAktif->id == $p->id) ? 'selected' : '' }}>
                                {{ $p->nama_periode }}
                                {{ $periodeAktif && $periodeAktif->id == $p->id ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-12 table-column-grow">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        {{-- Integrated Actions for DataTable --}}
                        <div id="table-actions-content" class="d-none">
                            <a href="{{ route('master-spm.create') }}" class="btn btn-primary shadow-sm btn-sm">
                                <i class="bi bi-plus-lg"></i> Tambah Data
                            </a>
                        </div>


                        <table class="table table-striped" id="table1" style="width: 100%; min-width: 1000px;">
                                <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th style="min-width: 350px;">SPM</th>
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
                                    @foreach ($spms as $i => $row)
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td class="fw-semibold">{{ $row->nama_spm }}</td>
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

                                                @if ($row->arah_target == 'range')
                                                    {{ rtrim(rtrim($row->target_min, '0'), '.') }} -
                                                    {{ rtrim(rtrim($row->target_max, '0'), '.') }} %
                                                @else
                                                    {{ $arah }}{{ rtrim(rtrim($row->target_spm, '0'), '.') }} %
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{ !empty($row->keterangan) ? $row->keterangan : 'Persentase (Numerator / Denominator)' }}
                                            </td>

                                            <td class="text-center">
                                                @if ($row->status_spm == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Non-Aktif</span>
                                                @endif

                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('master-spm.edit', $row->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form action="{{ route('master-spm.destroy', $row->id) }}" method="POST"
                                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus spm ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>

                                                @if (
                                                    $periodeAktif &&
                                                        $periodeDipilih &&
                                                        $periodeDipilih->id != $periodeAktif->id &&
                                                        is_null($row->sudah_di_periode_aktif))
                                                    <form action="{{ route('spm.active', $row->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm"
                                                            onclick="return confirm('Masukkan SPM ini ke periode aktif?')"
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
    </section>
@endsection
