@extends('layouts.app')

@section('title', 'Validasi Indikator')

@php
    use Carbon\Carbon;
    
    $isAdminMutu = in_array(auth()->user()->unit_id, [1, 2]);
    $periodeMulai = Carbon::parse($periode->tanggal_mulai);
    $periodeSelesai = Carbon::parse($periode->tanggal_selesai);
    $tahunAktif = range($periodeMulai->year, $periodeSelesai->year);
@endphp

@section('subtitle', 'Halaman verifikasi dan validasi data capaian indikator mutu oleh validator unit')

@section('content')
    <section class="section">
        {{-- Filter & Legend Section --}}
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
                            <label class="filter-label">Jenis Indikator</label>
                            <select name="kategori_indikator" class="form-select"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="">-- Semua Indikator --</option>
                                <option value="prioritas unit"
                                    {{ ($kategoriIndikator ?? '') == 'prioritas unit' ? 'selected' : '' }}>
                                    Prioritas Unit
                                </option>
                                <option value="nasional"
                                    {{ ($kategoriIndikator ?? '') == 'nasional' ? 'selected' : '' }}>
                                    Nasional
                                </option>
                                <option value="prioritas rs"
                                    {{ ($kategoriIndikator ?? '') == 'prioritas rs' ? 'selected' : '' }}>
                                    Prioritas RS
                                </option>
                            </select>
                        </div>

                        @if($availableMonths->count() > 1)
                        <div class="col-md-3">
                            <label class="filter-label">Bulan</label>
                            <select name="bulan" class="form-select"
                                onchange="document.getElementById('filterForm').submit()">
                                @forelse ($availableMonths as $m)
                                    <option value="{{ $m->bulan }}"
                                        {{ (int) request('bulan', $bulan) == $m->bulan && (int) request('tahun', $tahun) == $m->tahun ? 'selected' : '' }}>
                                        {{ $m->nama }}
                                    </option>
                                @empty
                                    <option value="">-- Tidak ada data --</option>
                                @endforelse
                            </select>
                            <input type="hidden" name="tahun" id="tahun_hidden" value="{{ request('tahun', $tahun) }}">
                        </div>
                        @else
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">
                        @endif
                    </form>
                </div>

            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-12">
            <div class="row flex-wrap flex-xl-nowrap mb-4">
                <div class="col-12 col-xl table-column-grow px-2" style="min-width: 0;">
                    <div class="card shadow-sm border-0">
                        @include('menu.IndikatorMutu.partials._legend')
                        <div class="card-body">
                            <div id="table-actions-content" class="d-none">
                                <div id="table-legend-placeholder"></div>
                            </div>

                            <div>
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">AKSI</th>
                                            <th style="min-width: 350px;">INDIKATOR</th>
                                            @if ($isAdminMutu)
                                                <th class="text-center">UNIT</th>
                                            @endif
                                            <th class="text-center">TARGET</th>
                                            <th class="text-center">NILAI</th>
                                            <th class="text-center">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($indikators as $indikator)
                                            @php
                                                $key = $indikator->id . '-' . $indikator->unit_id;
                                                $nilaiRekap = data_get($rekapBulanan, "$key.nilai_rekap");
                                                $nilaiDenom = data_get($rekapBulanan, "$key.denominator");
                                                $isSelected =
                                                    $selectedIndikatorId == $indikator->id;

                                                $colColor = '';
                                                $filterKategori = strtolower(request('kategori_indikator'));
                                                $jenisDb = strtolower($indikator->kategori_indikator ?? '');

                                                if ($filterKategori) {
                                                    if ($filterKategori === 'nasional') {
                                                        $colColor = 'table-danger';
                                                    } elseif ($filterKategori === 'prioritas rs') {
                                                        $colColor = 'table-success';
                                                    } elseif ($filterKategori === 'prioritas unit') {
                                                        $colColor = 'table-light';
                                                    }
                                                } else {
                                                    if (str_contains($jenisDb, 'nasional')) {
                                                        $colColor = 'table-danger';
                                                    } elseif (str_contains($jenisDb, 'prioritas rs')) {
                                                        $colColor = 'table-success';
                                                    } elseif (str_contains($jenisDb, 'prioritas unit')) {
                                                        $colColor = 'table-light';
                                                    }
                                                }
                                            @endphp

                                            <tr onclick="loadCalendar({{ $indikator->id }}, {{ $indikator->unit_id }})" 
                                                class="{{ $isSelected ? 'table-active' : '' }}"
                                                style="cursor: pointer;"
                                                data-indikator-id="{{ $indikator->id }}"
                                                data-unit-id="{{ $indikator->unit_id }}">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center" onclick="event.stopPropagation()">
                                                    <a href="javascript:void(0)" onclick="loadCalendar({{ $indikator->id }}, {{ $indikator->unit_id }}); event.stopPropagation();"
                                                        title="Lihat Kalender" class="text-decoration-none">
                                                        <i class="{{ $isSelected ? 'bi bi-calendar-check-fill text-primary' : 'bi bi-calendar-check text-primary' }}" style="font-size: 1.25rem;"></i>
                                                    </a>
                                                </td>
                                                <td class="{{ $colColor }} fw-semibold">
                                                    {{ $indikator->nama_indikator }}
                                                </td>
                                                @if ($isAdminMutu)
                                                    <td class="text-center">{{ $indikator->nama_unit }}</td>
                                                @endif
                                                <td class="text-center">
                                                    @php
                                                        $targetText = '';

                                                        $formatNumber = function ($value) {
                                                            if (floor($value) == $value) {
                                                                return number_format($value, 0);
                                                            }
                                                            return $value;
                                                        };
                                                        if ($indikator->arah_target === 'lebih_besar') {
                                                            $targetText =
                                                                '≥ ' .
                                                                $formatNumber($indikator->target_indikator) .
                                                                '%';
                                                        } elseif ($indikator->arah_target === 'lebih_kecil') {
                                                            $targetText =
                                                                '≤ ' .
                                                                $formatNumber($indikator->target_indikator) .
                                                                '%';
                                                        } elseif ($indikator->arah_target === 'range') {
                                                            $targetText =
                                                                $formatNumber($indikator->target_min) .
                                                                '% - ' .
                                                                $formatNumber($indikator->target_max) .
                                                                '%';
                                                        }
                                                    @endphp
                                                    {{ $targetText }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($nilaiRekap === null && $nilaiDenom === null)
                                                        <span>-</span>
                                                    @elseif((int) $nilaiDenom === 0)
                                                        <span>N/A</span>
                                                    @else
                                                        {{ fmod($nilaiRekap, 1) == 0 ? number_format($nilaiRekap, 0) : number_format($nilaiRekap, 1) }}%
                                                    @endif
                                                </td>


                                                @php
                                                    $rekapKey = $indikator->id . '-' . $indikator->unit_id;
                                                    $pencapaian = $rekapBulanan[$rekapKey]->pencapaian ?? null;
                                                @endphp

                                                {{-- STATUS --}}
                                                <td class="text-center">
                                                    @if ($nilaiRekap === null && $nilaiDenom === null)
                                                        <span class="badge bg-warning bg-opacity-75">Belum Mengisi</span>
                                                    @elseif((int) $nilaiDenom === 0)
                                                        <span class="badge bg-secondary">N/A</span>
                                                    @elseif($pencapaian === 'tercapai')
                                                        <span class="badge bg-success bg-opacity-75">Tercapai</span>
                                                    @elseif($pencapaian === 'tidak-tercapai')
                                                        <span class="badge bg-danger bg-opacity-75">Tidak Tercapai</span>
                                                    @else
                                                        <span class="badge bg-warning bg-opacity-75">Belum Mengisi</span>
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
                    @include('menu.IndikatorMutu.partials._kalender', [
                        'isValidatorPage' => true,
                        'noWrapper' => true
                    ])
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL DATA --}}
        @include('menu.IndikatorMutu.partials._modal_detail', ['isValidatorPage' => true])

        {{-- MODAL INPUT DATA (Tambah Baru) --}}
        <div class="modal fade" id="modalInputData" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius:14px;">
                    <div class="modal-header border-0">
                        <div>
                            <h5 class="modal-title text-success fw-semibold">+ Tambah Data Laporan</h5>
                            <small class="text-muted modal_dynamic_name">{{ $selectedIndikator->nama_indikator ?? '' }}</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="formInputData" method="POST" enctype="multipart/form-data"
                        action="{{ route('laporan-validator.store') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="indikator_id" id="modal_indikator_id"
                                value="{{ $selectedIndikatorId }}">
                            <input type="hidden" name="unit_id" id="modal_unit_id" value="{{ $selectedUnitId }}">
                            <input type="hidden" name="bulan" value="{{ request('bulan', $periodeMulai->month) }}">
                            <input type="hidden" name="tahun" value="{{ request('tahun', $periodeMulai->year) }}">
                            <input type="hidden" name="kategori_indikator" value="{{ request('kategori_indikator') }}">
                            <input type="hidden" name="tanggal_laporan" id="tanggal_laporan">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal Laporan</label>
                                <input type="text" id="tanggal_input_view" class="form-control" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Numerator <span class="text-danger">*</span></label>
                                <input type="number" name="numerator" id="input_numerator" class="form-control"
                                    required step="any">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Denominator <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="denominator" id="input_denominator" class="form-control"
                                    required step="any">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Unggah File</label>
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
                            <small class="text-muted modal_dynamic_name">{{ $selectedIndikator->nama_indikator ?? '' }}</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="formEditData" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Numerator</label>
                                <input type="number" name="numerator" id="edit_numerator" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Denominator</label>
                                <input type="number" name="denominator" id="edit_denominator" class="form-control"
                                    required>
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
            fetch(`/laporan-validator/${dataId}/detail`)
                .then(response => response.json())
                .then(data => {

                    // Tanggal pengisian
                    const tglIsi = new Date(data.tanggal_pengisian);
                    document.getElementById('detail_tanggal_pengisian').textContent =
                        tglIsi.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });

                    // Tanggal laporan
                    const tgl = new Date(data.tanggal_laporan);
                    document.getElementById('detail_tanggal').textContent = tgl.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

                    // Numerator & Denominator
                    document.getElementById('detail_numerator').textContent = data.numerator;
                    document.getElementById('detail_denominator').textContent = data.denominator;

                    // Nilai & Status
                    const detailNilaiElem = document.getElementById('detail_nilai');
                    const badgePencapaian = document.getElementById('detail_pencapaian');

                    if (data.denominator === 0) {
                        detailNilaiElem.textContent = 'N/A';
                        badgePencapaian.className = 'badge bg-secondary';
                        badgePencapaian.textContent = 'N/A';
                    } else if (data.nilai_validator === null) {
                        detailNilaiElem.textContent = '-';
                        badgePencapaian.className = 'badge bg-warning bg-opacity-75';
                        badgePencapaian.textContent = 'Belum Mengisi';
                    } else {
                        const nilai = Number(data.nilai_validator);
                        detailNilaiElem.textContent = (Number.isInteger(nilai) ? nilai : nilai.toFixed(1)) + '%';

                        if (data.pencapaian === 'tercapai') {
                            badgePencapaian.className = 'badge bg-success';
                            badgePencapaian.textContent = 'Tercapai';
                        } else if (data.pencapaian === 'tidak-tercapai') {
                            badgePencapaian.className = 'badge bg-danger';
                            badgePencapaian.textContent = 'Tidak Tercapai';
                        } else {
                            badgePencapaian.className = 'badge bg-warning bg-opacity-75';
                            badgePencapaian.textContent = 'Belum Mengisi';
                        }
                    }

                    // File laporan
                    document.getElementById('detail_file_link').href = `/storage/${data.file_laporan}`;

                    new bootstrap.Modal(document.getElementById('modalDetailData')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat detail data');
                });
        }

        function openEditModal() {

            fetch(`/laporan-validator/${currentDataId}/detail`)
                .then(res => res.json())
                .then(data => {

                    document.getElementById('edit_numerator').value = data.numerator;
                    document.getElementById('edit_denominator').value = data.denominator;

                    const form = document.getElementById('formEditData');
                    form.action = `/laporan-validator/${data.id}`;

                    bootstrap.Modal.getInstance(
                        document.getElementById('modalDetailData')
                    ).hide();

                    new bootstrap.Modal(
                        document.getElementById('modalEditData')
                    ).show();
                });
        }

        // AJAX Calendar Loader
        function loadCalendar(id, unitId) {
            const container = document.getElementById('calendar-container');
            container.style.opacity = '0.5';

            const bulan = document.querySelector('select[name="bulan"]').value;
            const tahun = document.querySelector('input[name="tahun"]')?.value || "{{ $tahun }}";

            const url = new URL(window.location.href);
            url.searchParams.set('indikator_id', id);
            url.searchParams.set('bulan', bulan);
            url.searchParams.set('tahun', tahun);

            // Sync modal context
            const modalIndikatorId = document.getElementById('modal_indikator_id');
            const modalUnitId = document.getElementById('modal_unit_id');
            if (modalIndikatorId) modalIndikatorId.value = id || '';
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

                const selectedRow = document.querySelector(`tr[data-indikator-id="${id}"][data-unit-id="${unitId}"]`);
                if (selectedRow) {
                    selectedRow.classList.add('table-active');
                    const icon = selectedRow.querySelector('i.bi-calendar-check');
                    if (icon) {
                        icon.classList.replace('bi-calendar-check', 'bi-calendar-check-fill');
                    }
                    
                    const namaIndikator = selectedRow.querySelector('td:nth-child(3)').textContent.trim();
                    document.querySelectorAll('.modal_dynamic_name').forEach(el => {
                        el.textContent = namaIndikator;
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

    <script>
        // Update tahun hidden input saat bulan berubah (untuk handle multi-tahun)
        document.querySelector('select[name="bulan"]').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            // Kita asumsikan availableMonths sudah mengandung tahun yang benar
            // Namun karena kita hanya kirim bulan ke route, kita butuh cara mencocokkan tahun.
            // Cara terbaik adalah menyimpan data tahun di attribuut option.
            @php 
                $monthYearMap = $availableMonths->mapWithKeys(fn($m) => [$m->bulan => $m->tahun]);
            @endphp
            const map = @json($monthYearMap);
            const selectedMonth = this.value;
            if (map[selectedMonth]) {
                document.getElementById('tahun_hidden').value = map[selectedMonth];
            }
        });
    </script>

@endpush
