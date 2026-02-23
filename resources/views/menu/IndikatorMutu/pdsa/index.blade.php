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

        @if (in_array(Auth::user()->unit_id, [1, 2]))

            {{-- =========================================
            TAMPILAN UNTUK UNIT 1 & 2 (MUTU)
            ========================================== --}}
            <div class="card">
                <div class="card-header">
                    <h5>Indikator Tidak Tercapai (Perlu PDSA)</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th>INDIKATOR</th>
                                    <th class="text-center">UNIT</th>
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
                                        <td>{{ $row->nama_indikator }}</td>
                                        <td class="text-center">{{ $row->nama_unit }}</td>
                                        <td class="text-center">{{ $row->tahun }}</td>
                                        <td class="text-center">{{ $row->quarter }}</td>
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
                                            @elseif ($row->status_pdsa === 'revised')
                                                <span class="badge bg-danger">Revisi</span>
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
                                                    <input type="hidden" name="tahun" value="{{ $row->tahun }}">
                                                    <input type="hidden" name="quarter" value="{{ $row->quarter }}">

                                                    <button type="submit" class="btn btn-primary btn-sm" title="Tugaskan PDSA">
                                                        Tugaskan
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Lihat / Isi PDSA --}}
                                                <a href="{{ route('pdsa.show', $row->pdsa_id) }}" class="btn btn-link p-0"
                                                    title="Lihat PDSA">
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

        @else

            <div class="card">
                <div class="card-header">
                    <h5>Daftar PDSA Perlu Ditindaklanjuti</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th>INDIKATOR</th>
                                    <th class="text-center">TAHUN</th>
                                    <th class="text-center">QUARTER</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pdsaList as $ind)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $ind->nama_indikator }}</td>
                                        <td class="text-center">{{ $ind->tahun }}</td>
                                        <td class="text-center">{{ $ind->quarter }}</td>
                                        <td class="text-center">
                                            @php
                                                $badgeClass = match ($ind->status_pdsa) {
                                                    'assigned' => 'bg-warning',
                                                    'submitted' => 'bg-info',
                                                    'revised' => 'bg-danger',
                                                    'approved' => 'bg-success',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp

                                            <span class="badge {{ $badgeClass }}">
                                                {{ ucfirst($ind->status_pdsa) }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            @if ($ind->status_pdsa === 'assigned')
                                                <a href="{{ route('pdsa.submit.form', $ind->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('pdsa.edit', $ind->id) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            Tidak ada data PDSA.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        @endif

    </section>
@endsection