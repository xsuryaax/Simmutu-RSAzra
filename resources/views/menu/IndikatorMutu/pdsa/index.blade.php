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
                        <strong>👋 Hello, {{ Auth::user()->username }}</strong>
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

                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Indikator</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Quarter</th>
                                <th class="text-center">Target</th>
                                <th class="text-center">Nilai</th>
                                <th class="text-center">Status PDSA</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $i => $row)
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
                                            <span class="badge bg-info">Disubmit</span>
                                        @elseif ($row->status_pdsa === 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        @if ($row->pdsa_id === null)
                                            {{-- Mutu menugaskan PDSA --}}
                                            <form action="{{ route('pdsa.store') }}" method="POST">
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
                                            <a href="{{ route('pdsa.show', $row->pdsa_id) }}"
                                                class="btn btn-outline-secondary btn-sm">
                                                Lihat
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Tidak ada indikator yang perlu PDSA
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection