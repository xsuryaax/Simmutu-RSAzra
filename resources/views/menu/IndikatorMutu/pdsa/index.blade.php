@extends('layouts.app')

@section('title', 'PDSA')
@section('subtitle', 'Siklus perbaikan mutu melalui tahapan Plan-Do-Study-Action')

@section('content')
    <section class="section">
        {{-- Filter & Actions Section --}}
        <div class="table-filter-section mb-4">
            <div class="row align-items-end">
                <div class="col">
                    <form method="GET" class="row g-3 align-items-end">
                        @if (in_array(Auth::user()->unit_id, [1, 2]))
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

                        <div class="col-md-3">
                            <label class="filter-label">Tahun</label>
                            <select name="tahun" class="form-select" onchange="this.form.submit()">
                                <option value="">-- Semua Tahun --</option>
                                @foreach ($tahunList as $tahun)
                                    <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-auto pb-2">
                    <div id="table-legend-placeholder"></div>
                </div>
            </div>
        </div>

        @if (in_array(Auth::user()->unit_id, [1, 2]))
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    {{-- Integrated Actions for DataTable --}}
                    <div id="table-actions-content" class="d-none">
                        <a href="{{ route('pdsa.export.pdf', ['unit_id' => request('unit_id'), 'tahun' => request('tahun')]) }}"
                            class="btn btn-danger shadow-sm btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Download PDF
                        </a>
                    </div>
                    

                    <table class="table table-striped" id="table1">
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
                                            @if ($row->arah_target === 'lebih_besar')
                                                ≥ {{ rtrim(rtrim(number_format($row->target_indikator, 2), '0'), '.') }}%
                                            @elseif ($row->arah_target === 'lebih_kecil')
                                                ≤ {{ rtrim(rtrim(number_format($row->target_indikator, 2), '0'), '.') }}%
                                            @elseif ($row->arah_target === 'range')
                                                {{ rtrim(rtrim(number_format($row->target_min, 2), '0'), '.') }}
                                                -
                                                {{ rtrim(rtrim(number_format($row->target_max, 2), '0'), '.') }}%
                                            @endif
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
                                                <a href="{{ route('pdsa.show', $row->pdsa_id) }}" class="btn btn-outline-primary btn-sm"
                                                    title="Lihat PDSA">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>

        @else
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    {{-- Integrated Actions for DataTable --}}
                    <div id="table-actions-content" class="d-none">
                        <a href="{{ route('pdsa.export.pdf', ['unit_id' => request('unit_id'), 'tahun' => request('tahun')]) }}"
                            class="btn btn-danger shadow-sm btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Download PDF
                        </a>
                    </div>


                    <table class="table table-striped" id="table1">
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

        @endif

    </section>
@endsection