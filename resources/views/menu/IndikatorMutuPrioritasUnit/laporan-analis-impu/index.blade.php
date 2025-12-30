@extends('layouts.app')

@section('title', 'Laporan dan Analisis')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Laporan dan Analisis</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola laporan dan analisis dalam sistem.
            </p>
        </div>
        <div class="page-header-right">
            <div class="logout-btn">
                <form method="POST" action="/logout">
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
                            Laporan dan Analisis
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
                <h5>Data Indikator Laporan</h5>
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
                                <th>NO</th>
                                <th>INDIKATOR</th>
                                <th>PERIODE</th>
                                <th>UNIT</th>
                                <th>TARGET</th>
                                <th>NILAI</th>
                                <th>STATUS</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($indikators as $indikator)
                                @php
                                    $key = $indikator->id . '-' . $indikator->unit_id;
                                    $nilaiRekap = $rekapBulanan[$key]->nilai_rekap ?? null;
                                @endphp

                                <tr class="table table-striped">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $indikator->nama_indikator_unit }}</td>
                                    <td>{{ \DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</td>
                                    <td>{{ $indikator->nama_unit }}</td>
                                    <td>{{ number_format($indikator->target_indikator_unit, 0) }} %</td>
                                    <td>
                                        @if ($nilaiRekap !== null)
                                            <span>
                                                {{ $nilaiRekap }} %
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Belum lengkap</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($nilaiRekap !== null)
                                            @if ($nilaiRekap >= $indikator->target_indikator_unit)
                                                <span class="badge bg-success">Tercapai</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Tercapai</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Belum lengkap</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm"
                                            onclick="openInputModal({{ $indikator->id }}, {{ $indikator->unit_id }})">
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

        <div class="card">
            <div class="card-header">
                <h5>Data Laporan Per Unit</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive table-dark">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>INDIKATOR</th>
                                <th>TANGGAL</th>
                                <th>UNIT</th>
                                <th>TARGET</th>
                                <th>NILAI</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = ($paginate->currentPage() - 1) * $paginate->perPage(); @endphp

                            @if(count($indikators) > 0 && $laporanHarian->flatten()->count() > 0)
                                @foreach ($indikators as $indikator)
                                    @foreach ($laporanHarian[$indikator->id] ?? [] as $lap)
                                        @php $no++; @endphp
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $indikator->nama_indikator_unit }}</td>
                                            <td>{{ \Carbon\Carbon::parse($lap->tanggal_laporan)->format('d F Y') }}</td>
                                            <td>{{ $indikator->nama_unit }}</td>
                                            <td>{{ number_format($indikator->target_indikator_unit, 0) }} %</td>
                                            <td>{{ $lap->nilai }} %</td>
                                            <td>
                                                <span class="badge bg-secondary">Sudah Input</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum Ada Laporan</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
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
                            <input type="hidden" name="indikator_unit_id" id="modal_indikator_id">
                            <input type="hidden" name="unit_id" id="modal_unit_id">
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
        const usedDates = @json($usedDates ?? []);

        function openInputModal(indikatorId, unitId) {
            document.getElementById('modal_indikator_id').value = indikatorId;
            document.getElementById('modal_unit_id').value = unitId;

            const select = document.getElementById('tanggal_laporan');
            select.innerHTML = '';

            let blocked = usedDates[indikatorId]?.[unitId] ?? [];
            const today = new Date().getDate();

            for (let i = 1; i <= 31; i++) {
                const opt = document.createElement('option');
                opt.value = i;
                opt.textContent = i;

                if (blocked.includes(i)) {
                    opt.disabled = true;
                    opt.textContent = i + ' (sudah diinput)';
                }

                if (i === today && !opt.disabled) {
                    opt.selected = true;
                }

                select.appendChild(opt);
            }

            document.getElementById('formInputData').reset();
            new bootstrap.Modal(document.getElementById('modalInputData')).show();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush