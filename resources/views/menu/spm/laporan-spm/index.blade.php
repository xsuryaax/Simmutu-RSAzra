@extends('layouts.app')

@section('title', 'Laporan dan Analisis')

@php
    use Carbon\Carbon;

    $isAdminMutu = in_array(auth()->user()->unit_id, [1, 2]);

    function formatSPM($nilai)
    {
        if ($nilai === null) {
            return '-';
        }
        $nilai = (float) $nilai;
        return (floor($nilai) == $nilai) ? number_format($nilai, 0, ',', '.') : number_format($nilai, 2, ',', '.');
    }

    function formatNumberSimple($value) {
        if ($value === null) return '-';
        $v = (float)$value;
        return (floor($v) == $v) ? number_format($v, 0, ',', '.') : rtrim(rtrim(number_format($v, 2, ',', '.'), '0'), ',');
    }

    $periodeMulai = Carbon::parse($periode->tanggal_mulai);
    $periodeSelesai = Carbon::parse($periode->tanggal_selesai);
    $tahunAktif = range($periodeMulai->year, $periodeSelesai->year);

    $bulanAwalPeriode = Carbon::parse($periode->tanggal_mulai)->month;
    $tahunAwalPeriode = Carbon::parse($periode->tanggal_mulai)->year;
    $bulanDipilih = request('bulan', $periodeMulai->month);
    $tahunDipilih = request('tahun', $periodeMulai->year);
    $isBulanPertamaPeriode = $bulanDipilih == $bulanAwalPeriode && $tahunDipilih == $tahunAwalPeriode;
@endphp

@section('title', 'Laporan SPM')
@section('subtitle', 'Halaman pengisian data capaian Standar Pelayanan Minimal (SPM) harian')

@section('content')
    <section class="section">
        {{-- Filter Section --}}
        <div class="table-filter-section mb-4">
            <div class="row align-items-end">
                <div class="col">
                    <form id="filterForm" method="GET" action="{{ url()->current() }}"
                        class="row g-3 align-items-end">
                        @if (in_array(auth()->user()->unit_id, [1, 2]))
                            <div class="col-md-3">
                                <label class="filter-label">Unit</label>
                                <select name="unit_id" class="form-select" onchange="filterForm.submit()">
                                    <option value="">-- Semua Unit --</option>
                                    @foreach ($units as $u)
                                        <option value="{{ $u->id }}"
                                            {{ $selectedUnitId == $u->id ? 'selected' : '' }}>
                                            {{ $u->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <label class="filter-label">Tahun</label>
                            <select name="tahun" class="form-select" onchange="filterForm.submit()">
                                @foreach ($tahunAktif as $t)
                                    <option value="{{ $t }}"
                                        {{ $tahun == $t ? 'selected' : '' }}>
                                        {{ $t }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="filter-label">Bulan</label>
                            @php
                                $tahunDipilih = $tahun;
                                $effectiveStart = $effectiveStart ?? $periodeMulai;
                                $bulanMulai = $tahunDipilih == $effectiveStart->year ? $effectiveStart->month : 1;
                                $bulanSelesai = $tahunDipilih == $periodeSelesai->year ? $periodeSelesai->month : 12;
                            @endphp
                            <select name="bulan" class="form-select" onchange="filterForm.submit()">
                                @for ($b = $bulanMulai; $b <= $bulanSelesai; $b++)
                                    <option value="{{ $b }}"
                                        {{ $bulan == $b ? 'selected' : '' }}>
                                        {{ Carbon::create()->month($b)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
            <div class="row flex-wrap flex-xl-nowrap mb-4">

                {{-- ================================================ --}}
                {{-- TABEL DATA SPM                              --}}
                {{-- ================================================ --}}
                <div class="col-12 col-xl table-column-grow px-2" style="min-width: 0;">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">

                            {{-- Tabel --}}
                            <div>
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">AKSI</th>
                                            <th style="min-width: 350px;">SPM</th>
                                            @if ($isAdminMutu)
                                                <th class="text-center">UNIT</th>
                                            @endif
                                            <th class="text-center">TARGET</th>
                                            <th class="text-center">PENGUMPUL</th>
                                            <th class="text-center">STATUS NILAI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($spms as $spm)
                                            @php
                                                $key = $spm->id . '-' . $spm->unit_id;
                                                $nilaiRekap = data_get($rekapBulanan, "$key.nilai_rekap");
                                                $nilaiDenom = data_get($rekapBulanan, "$key.denominator");
                                                $isSelected =
                                                    $selectedSpmId == $spm->id;
                                            @endphp

                                            <tr onclick="loadCalendar({{ $spm->id }}, {{ $spm->unit_id }})" 
                                                class="{{ $isSelected ? 'table-active' : '' }}"
                                                style="cursor: pointer;"
                                                data-spm-id="{{ $spm->id }}"
                                                data-unit-id="{{ $spm->unit_id }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center" onclick="event.stopPropagation()">
                                                    <a href="javascript:void(0)" onclick="loadCalendar({{ $spm->id }}, {{ $spm->unit_id }}); event.stopPropagation();"
                                                        title="Lihat Kalender" class="text-decoration-none">
                                                        <i class="{{ $isSelected ? 'bi bi-calendar-check-fill text-primary' : 'bi bi-calendar-check text-primary' }}" style="font-size: 1.25rem;"></i>
                                                    </a>
                                                </td>
                                                <td class="fw-semibold">
                                                    {{ $spm->nama_spm }}
                                                </td>

                                                @if ($isAdminMutu)
                                                    <td class="text-center">{{ $spm->nama_unit }}</td>
                                                @endif

                                                {{-- Target --}}
                                                <td class="text-center">
                                                    @php
                                                        $targetText = '';

                                                        $formatNumber = function ($value) {
                                                            $v = (float)$value;
                                                            return (floor($v) == $v) ? number_format($v, 0, ',', '.') : rtrim(rtrim(number_format($v, 2, ',', '.'), '0'), ',');
                                                        };
                                                        if ($spm->arah_target === 'lebih_besar') {
                                                            $targetText =
                                                                '≥ ' .
                                                                $formatNumber($spm->target_spm) .
                                                                '%';
                                                        } elseif ($spm->arah_target === 'lebih_kecil') {
                                                            $targetText =
                                                                '≤ ' .
                                                                $formatNumber($spm->target_spm) .
                                                                '%';
                                                        } elseif ($spm->arah_target === 'range') {
                                                            $targetText =
                                                                $formatNumber($spm->target_min) .
                                                                '% - ' .
                                                                $formatNumber($spm->target_max) .
                                                                '%';
                                                        }
                                                    @endphp
                                                    {{ $targetText }}
                                                </td>

                                                {{-- PENGUMPUL --}}
                                                <td class="text-center">

                                                    @if ($nilaiRekap === null && $nilaiDenom === null)
                                                        <span>-</span>
                                                    @elseif((int) $nilaiDenom === 0)
                                                        <span>N/A</span>
                                                    @else
                                                        <span>
                                                            {{ formatSPM($nilaiRekap) }}%
                                                        </span>
                                                    @endif

                                                </td>

                                                {{-- STATUS NILAI --}}
                                                <td class="text-center">
                                                    @if ($nilaiRekap === null && $nilaiDenom === null)
                                                        <span class="badge bg-warning bg-opacity-75">Belum Mengisi</span>
                                                    @elseif((int) $nilaiDenom === 0)
                                                        <span>N/A</span>
                                                    @else
                                                        @php
                                                            $tercapai = false;
                                                            if ($spm->arah_target == 'lebih_besar') {
                                                                $tercapai = $nilaiRekap >= $spm->target_spm;
                                                            } elseif ($spm->arah_target == 'lebih_kecil') {
                                                                $tercapai = $nilaiRekap <= $spm->target_spm;
                                                            } elseif ($spm->arah_target == 'range') {
                                                                $tercapai =
                                                                    $nilaiRekap >= $spm->target_min &&
                                                                    $nilaiRekap <= $spm->target_max;
                                                            }
                                                        @endphp
                                                        <span
                                                            class="badge bg-{{ $tercapai ? 'success' : 'danger' }} bg-opacity-75">
                                                            {{ $tercapai ? 'Tercapai' : 'Tidak Tercapai' }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

                <div id="calendar-container" class="col-12 col-xl-auto calendar-column-fixed px-2">
                    @include('menu.spm.partials._kalender', [
                        'isAnalisPage' => true,
                        'noWrapper' => true
                    ])
                </div>

            </div>
        </div>

        @include('menu.spm.partials._modal_detail', ['isAnalisPage' => true])

        <div class="modal fade" id="modalInputData" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius:14px;">
                    <div class="modal-header border-0">
                        <div>
                            <h5 class="modal-title text-success fw-semibold">+ Tambah Data Laporan</h5>
                            <small class="text-muted modal_dynamic_name">{{ $selectedSpm->nama_spm ?? '' }}</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="formInputData" method="POST" enctype="multipart/form-data"
                        action="{{ route('laporan-spm.store') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="spm_id" id="modal_spm_id"
                                value="{{ $selectedSpmId }}">
                            <input type="hidden" name="unit_id" id="modal_unit_id" value="{{ $selectedUnitId }}">
                            <input type="hidden" name="bulan" value="{{ request('bulan', $periodeMulai->month) }}">
                            <input type="hidden" name="tahun" value="{{ request('tahun', $periodeMulai->year) }}">
                            <input type="hidden" name="kategori_spm" value="{{ request('kategori_spm') }}">
                            <input type="hidden" name="tanggal_laporan" id="tanggal_laporan">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Laporan</label>
                                <input type="text" id="tanggal_input_view" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Numerator <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="numerator" class="form-control" required step="any">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Denominator <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="denominator" class="form-control" required step="any">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Unggah File
                                </label>
                                <input type="file" name="file_laporan" class="form-control">
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

        <div class="modal fade" id="modalEditData" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius:14px;">
                    <div class="modal-header border-0">
                        <div>
                            <h5 class="modal-title text-warning fw-semibold">
                                <i class="bi bi-pencil"></i> Edit Laporan
                            </h5>
                            <small class="text-muted modal_dynamic_name">{{ $selectedSpm->nama_spm ?? '' }}</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="formEditData" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Numerator <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="numerator" id="edit_numerator" class="form-control" required
                                    step="any">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Denominator <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="denominator" id="edit_denominator" class="form-control"
                                    required step="any">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ganti File (Opsional)</label>
                                <input type="file" name="file_laporan" class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save"></i> Simpan Perubahan
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
        let currentDataId = null;
        let currentTanggal = null;

        function handleDateClick(tanggalLaporan, sudahIsi, dataId) {
            currentTanggal = tanggalLaporan;
            currentDataId = dataId;

            if (sudahIsi) {
                loadDetailData(dataId);
            } else {
                openInputModal(tanggalLaporan);
            }
        }

        function openInputModal(tanggalLaporan) {
            document.getElementById('formInputData').reset();

            document.getElementById('tanggal_laporan').value = tanggalLaporan;

            const tgl = new Date(tanggalLaporan);
            document.getElementById('tanggal_input_view').value = tgl.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            new bootstrap.Modal(document.getElementById('modalInputData')).show();
        }

        function loadDetailData(dataId) {
            fetch(`/laporan-spm/${dataId}/detail`)
                .then(response => response.json())
                .then(data => {

                    const tglIsi = new Date(data.tanggal_pengisian);
                    document.getElementById('detail_tanggal_pengisian').textContent =
                        tglIsi.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });

                    const tgl = new Date(data.tanggal_laporan);
                    document.getElementById('detail_tanggal').textContent =
                        tgl.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });

                    const formatNum = (val) => {
                        if (val === null || val === undefined) return '-';
                        let n = parseFloat(val);
                        return Number.isInteger(n) ? n.toString() : parseFloat(n.toFixed(2)).toString();
                    };

                    document.getElementById('detail_numerator').textContent = formatNum(data.numerator);
                    document.getElementById('detail_denominator').textContent = formatNum(data.denominator);

                    let nilaiText = '-';
                    if (data.nilai === null || parseFloat(data.denominator) === 0) {
                        nilaiText = 'N/A';
                    } else {
                        nilaiText = formatNum(data.nilai) + '%';
                    }
                    document.getElementById('detail_nilai').textContent = nilaiText;

                    const badgePencapaian = document.getElementById('detail_pencapaian');
                    if (data.pencapaian === 'tercapai') {
                        badgePencapaian.className = 'badge bg-success';
                        badgePencapaian.textContent = 'Tercapai';
                    } else if (data.pencapaian === 'N/A') {
                        badgePencapaian.className = 'badge bg-secondary';
                        badgePencapaian.textContent = 'N/A';
                    } else {
                        badgePencapaian.className = 'badge bg-danger';
                        badgePencapaian.textContent = 'Tidak Tercapai';
                    }

                    document.getElementById('detail_file_link').href = `/storage/${data.file_laporan}`;

                    new bootstrap.Modal(document.getElementById('modalDetailData')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat detail data');
                });
        }

        function openEditModal() {
            fetch(`/laporan-spm/${currentDataId}/detail`)
                .then(res => res.json())
                .then(data => {

                    document.getElementById('edit_numerator').value = data.numerator;
                    document.getElementById('edit_denominator').value = data.denominator;


                    const form = document.getElementById('formEditData');
                    form.action = `/laporan-spm/${data.id}`;

                    bootstrap.Modal.getInstance(
                        document.getElementById('modalDetailData')
                    ).hide();

                    new bootstrap.Modal(
                        document.getElementById('modalEditData')
                    ).show();
                });
        }
        // function validateSpmForm(formId) {
        //     const form = document.getElementById(formId);
        //     const num = parseFloat(form.querySelector('input[name="numerator"]').value);
        //     const den = parseFloat(form.querySelector('input[name="denominator"]').value);

        //     if (num > den) {
        //         alert('Numerator tidak boleh lebih besar dari Denominator!');
        //         return false;
        //     }
        //     return true;
        // }
        // AJAX Calendar Loader
        function loadCalendar(id, unitId) {
            const container = document.getElementById('calendar-container');
            container.style.opacity = '0.5';

            const bulan = document.querySelector('select[name="bulan"]').value;
            const tahun = document.querySelector('select[name="tahun"]').value;

            const url = new URL(window.location.href);
            url.searchParams.set('spm_id', id);
            url.searchParams.set('bulan', bulan);
            url.searchParams.set('tahun', tahun);

            // Update modal context
            const modalSpmId = document.getElementById('modal_spm_id');
            const modalUnitId = document.getElementById('modal_unit_id');
            if (modalSpmId) modalSpmId.value = id || '';
            if (modalUnitId) modalUnitId.value = unitId || '';

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
                
                // Update URL without reload
                window.history.pushState({}, '', url);

                // Update highlights
                document.querySelectorAll('tr[onclick^="loadCalendar"]').forEach(tr => {
                    tr.classList.remove('table-active');
                    const icon = tr.querySelector('i.bi-calendar-check-fill');
                    if (icon) {
                        icon.classList.replace('bi-calendar-check-fill', 'bi-calendar-check');
                    }
                });

                const selectedRow = document.querySelector(`tr[data-spm-id="${id}"][data-unit-id="${unitId}"]`);
                if (selectedRow) {
                    selectedRow.classList.add('table-active');
                    const icon = selectedRow.querySelector('i.bi-calendar-check');
                    if (icon) {
                        icon.classList.replace('bi-calendar-check', 'bi-calendar-check-fill');
                    }
                    
                    const namaSpm = selectedRow.querySelector('td:nth-child(3)').textContent.trim();
                    document.querySelectorAll('.modal_dynamic_name').forEach(el => {
                        el.textContent = namaSpm;
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                container.style.opacity = '1';
                window.location.href = url.href; // Fallback
            });
        }
    </script>


@endpush
