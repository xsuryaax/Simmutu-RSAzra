@extends('layouts.app')

{{-- Title Halaman --}}
@section('title', 'PDSA')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>PDSA (Plan Do Study Action)</h3>
            <p class="text-subtitle text-muted">
                Daftar indikator mutu yang tidak tercapai dan memerlukan PDSA
            </p>
        </div>

        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
                    <span class="greeting-card">
                        <strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong>
                    </span>
                    @csrf
                    <button type="submit" class="btn btn-primary logout-btn">
                        <i class="bi bi-box-arrow-right"></i> Logout
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
                            PDSA
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
            <div class="card-header">
                <h5>Indikator Tidak Tercapai (Perlu PDSA)</h5>
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="GET" action="{{ route('pdsa.index') }}" class="row g-2 mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-select">
                            @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Quarter</label>
                        <select name="quarter" class="form-select">
                            @foreach (['Q1', 'Q2', 'Q3', 'Q4'] as $q)
                                <option value="{{ $q }}" {{ $quarter === $q ? 'selected' : '' }}>
                                    {{ $q }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                    </div>
                </form>

                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>INDIKATOR</th>
                                <th class="text-center">UNTI</th>
                                <th class="text-center">TAHUN</th>
                                <th class="text-center">QUARTER</th>
                                <th class="text-center">TARGET</th>
                                <th class="text-center">NILAI</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $i => $row)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>

                                    <td>
                                        {{ $row->nama_indikator ?? 'ID: ' . $row->indikator_id }}
                                    </td>

                                    <td class="text-center">
                                        {{ $row->nama_unit ?? 'ID: ' . $row->unit_id }}
                                    </td>

                                    <td class="text-center">{{ $tahun }}</td>
                                    <td class="text-center">{{ $quarter }}</td>
                                    <td class="text-center">
                                        {{ rtrim(rtrim(number_format($row->target_indikator, 2), '0'), '.') }}%
                                    </td>

                                    <td class="text-center">
                                        <span class="fw-semibold">
                                            {{ rtrim(rtrim(number_format($row->nilai_quarter, 2), '0'), '.') }}%
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if ($row->status_pdsa === null)
                                            <span>-</span>
                                        @elseif ($row->status_pdsa === 'assigned')
                                            <span class="badge bg-warning">Ditugaskan</span>
                                        @elseif ($row->status_pdsa === 'submitted')
                                            <span class="badge bg-info">Sudah Isi</span>
                                        @elseif ($row->status_pdsa === 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($row->pdsa_id === null)
                                            {{-- Mutu menugaskan PDSA --}}
                                            <form action="{{ route('pdsa.assign') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="indikator_id" value="{{ $row->indikator_id }}">
                                                <input type="hidden" name="unit_id" value="{{ $row->unit_id }}">
                                                <input type="hidden" name="tahun" value="{{ $tahun }}">
                                                <input type="hidden" name="quarter" value="{{ $quarter }}">

                                                <button type="submit" class="btn btn-link p-0" title="Tugaskan PDSA">
                                                    <i class="bi bi-send fs-5 text-primary"></i>
                                                </button>
                                            </form>
                                        @else
                                            {{-- Lihat / Isi PDSA --}}
                                            <a href="{{ route('pdsa.show', $row->pdsa_id) }}" class="btn btn-link p-0" title="Lihat PDSA">
                                                <i class="bi bi-eye fs-5 text-primary"></i>
                                            </a>
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