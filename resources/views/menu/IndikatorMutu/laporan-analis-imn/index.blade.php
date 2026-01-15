@extends('layouts.app')

@section('title', 'Laporan dan Analisis IMN')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Laporan dan Analisis Indikator Mutu Nasional</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola laporan dan analisis indikator mutu nasional.
            </p>
        </div>
        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
                    <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->username }}</strong></span>
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
                            Laporan dan Analisis IMN
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="section">

        {{-- ================= CARD ATAS ================= --}}
        <div class="card">
            <div class="card-header">
                <h5>Data Indikator Mutu Nasional</h5>
            </div>

            <div class="card-body">

                {{-- FILTER --}}
                <form method="GET" class="row g-2 align-items-end mb-4">
                    <div class="col-md-2">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-control">
                            @foreach (range(1, 12) as $b)
                                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                    {{ \DateTime::createFromFormat('!m', $b)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-control">
                            @foreach (range(date('Y') - 5, date('Y') + 2) as $t)
                                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </form>

                {{-- TABLE --}}
                <div class="table-responsive table-dark">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>INDIKATOR</th>
                                <th>PERIODE</th>
                                <th>TARGET</th>
                                <th>NILAI</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($indikatorLaporan as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $row->nama_indikator }}</td>
                                    <td>{{ \DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}
                                    </td>
                                    <td>{{ rtrim(rtrim($row->target, '0'), '.') }}%</td>

                                    <td>
                                        @if ($row->nilai !== null)
                                            {{ rtrim(rtrim($row->nilai, '0'), '.') }}%
                                        @else
                                            <span class="badge bg-secondary">Belum Input</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($row->nilai !== null)
                                            @if ($row->nilai >= $row->target)
                                                <span class="badge bg-success">Tercapai</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tercapai</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Belum Lengkap</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button class="btn btn-success btn-sm"
                                            onclick="openInputModal({{ $row->id }})">
                                            + Input
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        {{-- ================= CARD BAWAH ================= --}}
        <div class="card">
            <div class="card-header">
                <h5>Data Laporan Indikator Mutu Nasional</h5>
            </div>

            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>INDIKATOR</th>
                                <th>TANGGAL</th>
                                <th>TARGET</th>
                                <th>NILAI</th>
                                <th>FILE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporanNasional as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $row->nama_indikator }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->tanggal_laporan)->format('d F Y') }}</td>
                                    <td>{{ rtrim(rtrim($row->target, '0'), '.') }}%</td>
                                    <td>{{ rtrim(rtrim($row->nilai, '0'), '.') }}%</td>
                                    <td>
                                        @if ($row->file_laporan)
                                            <a href="{{ asset('storage/' . $row->file_laporan) }}" target="_blank"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-file-earmark-arrow-down"></i> Lihat File
                                            </a>
                                        @else
                                            <span class="badge bg-secondary">Tidak Ada File</span>
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

    {{-- ================= MODAL INPUT ================= --}}
    <div class="modal fade" id="modalInput" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius:14px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-success fw-semibold">
                        + Input Laporan Nasional
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('laporan-analis-imn.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="indikator_id" id="modal_indikator_id">
                        <input type="hidden" name="bulan" value="{{ $bulan }}">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <select name="tanggal_laporan" id="tanggal_laporan" class="form-select" required></select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Numerator</label>
                            <input type="number" name="numerator" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Denominator</label>
                            <input type="number" name="denominator" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Unggah File</label>
                            <input type="file" name="file_laporan" class="form-control" required>
                        </div>

                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        function openInputModal(indikatorId) {
            document.getElementById('modal_indikator_id').value = indikatorId;

            const select = document.getElementById('tanggal_laporan');
            select.innerHTML = '';

            const today = new Date().getDate();

            for (let i = 1; i <= 31; i++) {
                const opt = document.createElement('option');
                opt.value = i;
                opt.textContent = i;

                if (i === today) {
                    opt.selected = true;
                }

                select.appendChild(opt);
            }

            new bootstrap.Modal(document.getElementById('modalInput')).show();
        }
    </script>
@endpush
