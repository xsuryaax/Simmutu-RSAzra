@extends('layouts.app')

@section('title', 'Laporan dan Analisis IMPU')

@php
    $isAdminMutu = in_array(auth()->user()->unit_id, [1, 2]);
@endphp

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Laporan dan Analisis IMPU</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola laporan dan analisis Indikator Mutu Prioritas Unit.
            </p>
        </div>
        <div class="page-header-right">
            <div class="logout-btn">
                <form method="POST" action="/logout">
                    <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->username }}</strong></span>
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </div>
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Laporan dan Analisis IMPU
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
                <h5>Data Indikator Laporan IMPU</h5>
            </div>

            <div class="card-body">

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

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

                <div class="table-responsive table-dark">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>INDIKATOR</th>
                                @if ($isAdminMutu)
                                    <th class="text-center">UNIT</th>
                                @endif
                                <th class="text-center">TARGET</th>
                                <th class="text-center">NILAI</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($indikators as $indikator)
                                @php
                                    $key = $indikator->id . '-' . $indikator->unit_id;
                                    $nilaiRekap = $rekapBulanan[$key]->nilai_rekap ?? null;
                                @endphp

                                <tr class="table table-striped">
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $indikator->nama_indikator }}</td>
                                    @if ($isAdminMutu)
                                        <td class="text-center">{{ $indikator->nama_unit }}</td>
                                    @endif
                                    <td class="text-center">{{ number_format($indikator->target_indikator, 0) }}%</td>
                                    <td class="text-center">
                                        @if ($nilaiRekap !== null)
                                                                <span class="fw-semibold text-dark">
                                                                    {{ floor($nilaiRekap) == $nilaiRekap
                                            ? number_format($nilaiRekap, 0)
                                            : number_format($nilaiRekap, 2) }}%
                                                                </span>
                                        @else
                                            <span class="text-muted fst-italic">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($nilaiRekap !== null)
                                            @if ($nilaiRekap >= $indikator->target_indikator)
                                                <span class="badge bg-success bg-opacity-75">Tercapai</span>
                                            @else
                                                <span class="badge bg-danger bg-opacity-75">Tidak Tercapai</span>
                                            @endif
                                        @else
                                            <span class="badge bg-warning bg-opacity-75">Belum Mengisi</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)"
                                            onclick="openInputModal({{ $indikator->id }}, {{ $indikator->unit_id }})"
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

        <div class="card">
            <div class="card-header">
                <h5>Data Laporan Per Indikator</h5>
            </div>

            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>INDIKATOR</th>
                                <th class="text-center">TANGGAL</th>
                                @if ($isAdminMutu)
                                    <th class="text-center">UNIT</th>
                                @endif
                                <th class="text-center">TARGET</th>
                                <th class="text-center">NILAI</th>
                                <th class="text-center">FILE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($paginate->currentPage() - 1) * $paginate->perPage(); @endphp
                            @foreach ($indikators as $indikator)
                                @foreach ($laporanHarian[$indikator->id] ?? [] as $lap)
                                    @php $no++; @endphp
                                    <tr>
                                        <td class="text-center">{{ $no }}</td>
                                        <td>{{ $indikator->nama_indikator }}</td>
                                        <td class="text-center">{{ \Carbon\Carbon::parse($lap->created_at)->format('d F Y') }}</td>
                                        @if ($isAdminMutu)
                                            <td class="text-center">{{ $indikator->nama_unit }}</td>
                                        @endif
                                        <td class="text-center">{{ number_format($indikator->target_indikator, 0) }}%</td>
                                        <td class="text-center">{{ $lap->nilai }}%</td>
                                        <td class="text-center">
                                            @if(!empty($lap->file_laporan))
                                                <a href="{{ asset('storage/' . $lap->file_laporan) }}" target="_blank"
                                                    class="btn btn-lg text-primary" title="Download File Laporan">
                                                    <i class="bi bi-file-earmark-arrow-down fs-5"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Showing {{ $paginate->firstItem() }} to {{ $paginate->lastItem() }} of {{ $paginate->total() }}
                        results
                    </div>
                    <div>
                        {{ $paginate->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>


            </div>
        </div>

        <div class="modal fade" id="modalInputData" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius:14px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-success fw-semibold">+ Tambah Data Indikator</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="formInputData" method="POST" enctype="multipart/form-data"
                        action="{{ route('laporan-analis-impu.store') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="indikator_id" id="modal_indikator_id">
                            <input type="hidden" name="unit_id" id="modal_unit_id">
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Pengisian</label>
                                <input type="text" id="tanggal_laporan_view" class="form-control" disabled>
                            </div>
                            <input type="hidden" name="tanggal_laporan" id="tanggal_laporan">


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
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        function openInputModal(indikatorId, unitId) {
            document.getElementById('formInputData').reset();
            document.querySelector('input[name="file_laporan"]').value = '';

            document.getElementById('modal_indikator_id').value = indikatorId;
            document.getElementById('modal_unit_id').value = unitId;

            const today = new Date();

            document.getElementById('tanggal_laporan_view').value =
                today.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

            document.getElementById('tanggal_laporan').value =
                today.toISOString().slice(0, 10);

            new bootstrap.Modal(document.getElementById('modalInputData')).show();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush