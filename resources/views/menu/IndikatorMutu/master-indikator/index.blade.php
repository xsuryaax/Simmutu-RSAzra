@extends('layouts.app')

@section('title', 'Master Indikator')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Master Indikator</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola master indikator dalam sistem.
            </p>
        </div>
        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
                    <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong></span>
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
                            Master Indikator
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
                <h5>Data Indikator</h5>
                <a href="{{ route('master-indikator.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
            </div>

            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    @php $isAdminMutu = in_array(auth()->user()->unit_id, [1, 2]); @endphp

                    <form method="GET" action="{{ route('master-indikator.index') }}" class="row g-2 mb-3 align-items-end">
                        <div class="col-md-2">
                            <label>Filter Periode</label>
                            <select name="periode_id" class="form-select" onchange="this.form.submit()">
                                @foreach ($periodes as $p)
                                    <option value="{{ $p->id }}" {{ $periodeId == $p->id ? 'selected' : '' }}>
                                        {{ $p->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @if ($isAdminMutu)
                            <div class="col-md-3">
                                <label>Filter Unit</label>
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

                    <div class="mb-3 d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger me-2" style="width: 20px; height: 20px;">&nbsp;</span>
                            <small class="text-primary text-primary-dark">Nasional</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success me-2" style="width: 20px; height: 20px;">&nbsp;</span>
                            <small class="text-primary text-primary-dark">Prioritas RS</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-light me-2" style="width: 20px; height: 20px;">&nbsp;</span>
                            <small class="text-primary text-primary-dark">Prioritas Unit</small>
                        </div>
                    </div>

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>INDIKATOR</th>
                                @if ($isAdminMutu)
                                    <th class="text-center">UNIT</th>
                                @endif
                                <th class="text-center">TARGET</th>
                                <th class="text-center">TIPE</th>
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

                                    <td class="text-center">{{ ucfirst($row->tipe_indikator) }}</td>
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
    </section>
@endsection