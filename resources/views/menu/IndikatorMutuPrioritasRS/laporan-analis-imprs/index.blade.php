@extends('layouts.app')

@section('title', 'Laporan dan Analisis IMPRS')

@section('page-title')
<div class="page-header">
    <div class="page-header-left">
        <h3>Laporan dan Analisis IMPRS</h3>
        <p class="text-subtitle text-muted">
            Halaman untuk mengelola laporan dan analisis Indikator Mutu Prioritas RS.
        </p>
    </div>
    <div class="page-header-right d-flex gap-3 align-items-center">
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Laporan dan Analisis IMPRS</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
<section class="section">
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
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
                        <i class="bi bi-funnel"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Rekap Bulanan IMPRS</h5>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>KATEGORI</th>
                        <th>INDIKATOR</th>
                        <th>PERIODE</th>
                        <th>TARGET</th>
                        <th>NILAI</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($indikators as $indikator)
                        @php
                            $nilaiRekap = $rekapBulanan[$indikator->id]->nilai_rekap ?? null;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $indikator->nama_kategori_imprs }}</td>
                            <td>{{ $indikator->nama_imprs }}</td>
                            <td>{{ \DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</td>
                            <td>{{ number_format($indikator->target_imprs, 0) }} %</td>
                            <td>
                                @if ($nilaiRekap !== null)
                                    {{ $nilaiRekap }} %
                                @else
                                    <span class="badge bg-secondary">Belum lengkap</span>
                                @endif
                            </td>
                            <td>
                                @if ($nilaiRekap !== null)
                                    @if ($nilaiRekap >= $indikator->target_imprs)
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
                                    onclick="openInputModal({{ $indikator->id }})">
                                    + Input
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Data Laporan IMPRS</h5>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>KATEGORI</th>
                        <th>INDIKATOR</th>
                        <th>UNIT</th>
                        <th>TANGGAL</th>
                        <th>TARGET</th>
                        <th>NILAI</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = ($paginate->currentPage() - 1) * $paginate->perPage(); @endphp

                    @forelse ($laporanHarian as $indikatorId => $laporans)
                        @foreach ($laporans as $lap)
                            @php
                                $indikator = $indikators->firstWhere('id', $indikatorId);
                                $no++;
                            @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $indikator->nama_kategori_imprs }}</td>
                                <td>{{ $indikator->nama_imprs }}</td>
                                <td>{{ $lap->nama_unit }}</td>
                                <td>{{ \Carbon\Carbon::parse($lap->tanggal_laporan)->format('d F Y') }}</td>
                                <td>{{ number_format($indikator->target_imprs, 0) }} %</td>
                                <td>{{ $lap->nilai }} %</td>
                                <td>
                                    <span class="badge bg-success">Sudah Input</span>
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada laporan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $paginate->firstItem() }} to {{ $paginate->lastItem() }}
                    of {{ $paginate->total() }} results
                </div>
                <div>
                    {{ $paginate->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MODAL INPUT ================= --}}
    <div class="modal fade" id="modalInputData" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius:14px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-success fw-semibold">+ Tambah Data Indikator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" enctype="multipart/form-data"
                    action="{{ route('laporan-analis-imprs.store') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="imprs_id" id="modal_indikator_id">
                        <input type="hidden" name="bulan" value="{{ $bulan }}">
                        <input type="hidden" name="tahun" value="{{ $tahun }}">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <select name="tanggal_laporan" id="tanggal_laporan"
                                class="form-select" required></select>
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
    const usedDates = @json($usedDates ?: []);

    function openInputModal(indikatorId) {
        document.getElementById('modal_indikator_id').value = indikatorId;

        const select = document.getElementById('tanggal_laporan');
        select.innerHTML = '';

        let blocked = usedDates[indikatorId] ?? [];
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

        new bootstrap.Modal(document.getElementById('modalInputData')).show();
    }
</script>
@endpush
