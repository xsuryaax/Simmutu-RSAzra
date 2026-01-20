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
                                <th class="text-center">NO</th>
                                <th>INDIKATOR</th>
                                <th class="text-center">TARGET</th>
                                <th class="text-center">NILAI</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($indikatorLaporan as $i => $row)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $row->nama_indikator }}</td>
                                    <td class="text-center">{{ rtrim(rtrim($row->target, '0'), '.') }}%</td>

                                    <td class="text-center">
                                        @if ($row->nilai !== null)
                                                                <span class="fw-semibold text-dark">
                                                                    {{ floor($row->nilai) == $row->nilai
                                            ? number_format($row->nilai, 0)
                                            : number_format($row->nilai, 2) }}%
                                                                </span>
                                        @else
                                            <span class="text-muted fst-italic">-</span>
                                        @endif
                                    </td>


                                    <td class="text-center">
                                        @if ($row->nilai !== null)
                                            @if ($row->nilai >= $row->target)
                                                <span class="badge bg-success">Tercapai</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tercapai</span>
                                            @endif
                                        @else
                                            <span class="badge bg-warning">Belum Mengisi</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" onclick="openInputModal({{ $row->id }})"
                                            class="text-primary" title="Input / Edit Nilai">
                                            <i class="bi bi-pencil-square fs-5 text-dark action-icon"></i>
                                        </a>
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
                                <th class="text-center">NO</th>
                                <th>INDIKATOR</th>
                                <th class="text-center">TANGGAL</th>
                                <th class="text-center">TARGET</th>
                                <th class="text-center">NILAI</th>
                                <th class="text-center">FILE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporanNasional as $i => $row)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $row->nama_indikator }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($row->created_at)->format('d F Y') }}
                                    </td>
                                    <td class="text-center">{{ rtrim(rtrim($row->target, '0'), '.') }}%</td>
                                    <td class="text-center">{{ rtrim(rtrim($row->nilai, '0'), '.') }}%</td>
                                    <td class="text-center">
                                        @if(!empty($row->file_laporan))
                                            <a href="{{ asset('storage/' . $row->file_laporan) }}" target="_blank"
                                                class="btn btn-lg text-primary" title="Download File Laporan">
                                                <i class="bi bi-file-earmark-arrow-down fs-5"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
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
                        <input type="hidden" name="tanggal_laporan" id="tanggal_laporan">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal Input</label>
                            <input type="text" id="tanggal_laporan_view" class="form-control" disabled>
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
            // reset form
            const form = document.querySelector('#modalInput form');
            form.reset();

            document.getElementById('modal_indikator_id').value = indikatorId;

            const today = new Date();

            // tampilkan tanggal hari ini (read-only)
            document.getElementById('tanggal_laporan_view').value =
                today.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

            // backend tetap terima tanggal hari ini
            document.getElementById('tanggal_laporan').value =
                today.toISOString().slice(0, 10); // YYYY-MM-DD

            new bootstrap.Modal(document.getElementById('modalInput')).show();
        }
    </script>
@endpush