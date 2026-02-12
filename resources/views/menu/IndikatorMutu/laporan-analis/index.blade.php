@extends('layouts.app')

@section('title', 'Laporan dan Analisis')

@php
    $isAdminMutu = in_array(auth()->user()->unit_id, [1, 2]);
@endphp

@php
    use Carbon\Carbon;

    $periodeMulai = Carbon::parse($periode->tanggal_mulai);
    $periodeSelesai = Carbon::parse($periode->tanggal_selesai);

    $tahunAktif = range($periodeMulai->year, $periodeSelesai->year);
@endphp

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Laporan dan Analisis</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola laporan dan analisis.
            </p>
        </div>
        <div class="page-header-right">
            <div class="logout-btn">
                <form method="POST" action="/logout">
                    <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong></span>
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
        <div class="col-12 col-md-12 col-lg-12">
            <div class="row mb-4">
                <div class="col-5 col-lg-7 col-md-5 px-2">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Indikator Laporan</h5>
                        </div>

                        <div class="card-body">

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form id="filterForm" method="GET" action="{{ url()->current() }}" class="row g-2 align-items-end mb-4">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Jenis Indikator</label>
                                    <select name="kategori_indikator" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                        <option value="">-- Semua Indikator --</option>
                                        <option value="prioritas unit"
                                            {{ request('kategori_indikator') == 'prioritas unit' ? 'selected' : '' }}>
                                            Prioritas Unit
                                        </option>
                                        <option value="nasional"
                                            {{ request('kategori_indikator') == 'nasional' ? 'selected' : '' }}>
                                            Nasional
                                        </option>
                                        <option value="prioritas rs"
                                            {{ request('kategori_indikator') == 'prioritas rs' ? 'selected' : '' }}>
                                            Prioritas RS
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Tahun</label>
                                    <select name="tahun" class="form-select" onchange="filterForm.submit()">
                                        @foreach ($tahunAktif as $t)
                                            <option value="{{ $t }}"
                                                {{ request('tahun', $periodeMulai->year) == $t ? 'selected' : '' }}>
                                                {{ $t }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Bulan</label>
                                    <select name="bulan" class="form-select" onchange="filterForm.submit()">
                                        @php
                                            $tahunDipilih = request('tahun', $periodeMulai->year);
                                            $bulanMulai =
                                                $tahunDipilih == $periodeMulai->year ? $periodeMulai->month : 1;
                                            $bulanSelesai =
                                                $tahunDipilih == $periodeSelesai->year ? $periodeSelesai->month : 12;
                                        @endphp

                                        @for ($b = $bulanMulai; $b <= $bulanSelesai; $b++)
                                            <option value="{{ $b }}"
                                                {{ request('bulan', $periodeMulai->month) == $b ? 'selected' : '' }}>
                                                {{ Carbon::create()->month($b)->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            
                            </form>

                            <div class="mb-3 d-flex flex-wrap gap-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger me-2"
                                        style="width: 20px; height: 20px; border: 1px solid #f0f2f4;">&nbsp;</span>
                                    <small class="text-primary text-primary-dark">Nasional</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success me-2"
                                        style="width: 20px; height: 20px; border: 1px solid #f0f2f4;">&nbsp;</span>
                                    <small class="text-primary text-primary-dark">Prioritas RS</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light me-2"
                                        style="width: 20px; height: 20px; border: 1px solid #f0f2f4;">&nbsp;</span>
                                    <small class="text-primary text-primary-dark">Unit</small>
                                </div>
                            </div>

                            <div class="table-parent-container table-responsive-md table-dark">
                                <table class="table" id="table1">
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
                                                $isSelected =
                                                $selectedIndikatorId == $indikator->id &&
                                                $selectedUnitId == $indikator->unit_id;

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
                                                } 
                                                    
                                                else {
                                                    if (str_contains($jenisDb, 'nasional')) {
                                                        $colColor = 'table-danger';
                                                    } elseif (str_contains($jenisDb, 'prioritas rs')) {
                                                        $colColor = 'table-success';
                                                    } elseif (str_contains($jenisDb, 'prioritas unit')) {
                                                        $colColor = 'table-light';
                                                    }
                                                }
                                            @endphp

                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="{{ $colColor }} fw-semibold">
                                                    {{ $indikator->nama_indikator }}
                                                </td>
                                                @if ($isAdminMutu)
                                                    <td class="text-center">{{ $indikator->nama_unit }}</td>
                                                @endif
                                                <td class="text-center">
                                                    {{ number_format($indikator->target_indikator, 0) }}%
                                                </td>
                                                <td class="text-center">
                                                    @if ($nilaiRekap !== null)
                                                        <span>
                                                            {{ fmod($nilaiRekap, 1) == 0 
                                                                ? number_format($nilaiRekap, 0) 
                                                                : number_format($nilaiRekap, 1) }}%
                                                        </span>
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($nilaiRekap !== null)
                                                        @if ($nilaiRekap >= $indikator->target_indikator)
                                                            <span class="badge bg-success bg-opacity-75">Tercapai</span>
                                                        @else
                                                            <span class="badge bg-danger bg-opacity-75">Tidak
                                                                Tercapai</span>
                                                        @endif
                                                    @else
                                                        <span class="badge bg-warning bg-opacity-75">Belum Mengisi</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('laporan-analis.index', [
                                                        'kategori_indikator' =>
                                                            request()->has('kategori_indikator') && request('kategori_indikator') !== '' ? request('kategori_indikator') : null,
                                                        'bulan' => request('bulan', $periodeMulai->month),
                                                        'tahun' => request('tahun', $periodeMulai->year),
                                                        'indikator_id' => $indikator->id,
                                                        'unit_id' => $indikator->unit_id,
                                                    ]) }}"
                                                        class="text-primary" title="Lihat Kalender">
                                                        <i
                                                            class="bi bi-calendar-check fs-5 {{ $isSelected ? 'text-primary' : 'text-dark' }} action-icon"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($kalenderData)
                    <div class="col-5 col-lg-5 col-md-5 px-2">
                        <div class="card" id="kalenderSection">
                            <div class="card-header">
                                <div class="d-flex justify-content-center align-items-center text-center">
                                    <div>
                                        <h5 class="mb-1">{{ $selectedIndikator->nama_indikator }}</h5>
                                        <small class="text-muted">
                                            @if ($isAdminMutu)
                                                {{ $selectedIndikator->nama_unit }} -
                                            @endif
                                            {{ $kalenderData['bulanNama'] }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="calendar-grid border-0 shadow-sm rounded-3">
                                    @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $hari)
                                        <div class="calendar-header">{{ $hari }}</div>
                                    @endforeach

                                    @for ($i = 0; $i < $kalenderData['skip']; $i++)
                                        <div class="calendar-day bg-light"></div>
                                    @endfor

                                    @for ($d = 1; $d <= $kalenderData['daysInMonth']; $d++)
                                        @php
                                            $tglFull = Carbon::create($tahun, $bulan, $d)->format('Y-m-d');
                                            $isToday = $tglFull == date('Y-m-d');
                                            $pengisian = $kalenderData['dataPengisian']->get($tglFull);
                                            $sudahIsi = $pengisian !== null;
                                        @endphp

                                        <div class="calendar-day"
                                            onclick="handleDateClick(
'{{ $tglFull }}',
{{ $sudahIsi ? 'true' : 'false' }},
{{ $sudahIsi ? $pengisian->id : 'null' }},
'{{ $sudahIsi ? $pengisian->table_source : '' }}'
)"

                                            style="cursor:pointer">
                                            <span
                                                class="{{ $isToday ? 'today-highlight' : '' }}">{{ $d }}</span>

                                            <div class="d-block mt-1 text-center">
                                                @if ($sudahIsi)
                                                    <span class="dot bg-success d-block mx-auto mb-1"></span>
                                                    <small class="text-muted fw-semibold">
                                                        {{ $pengisian->numerator }} / {{ $pengisian->denominator }}
                                                    </small>
                                                @else
                                                    <span class="dot border d-block mx-auto"></span>
                                                @endif
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- MODAL DETAIL DATA --}}
        <div class="modal fade" id="modalDetailData" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius:14px;">
                    <div class="modal-header border-0">
                        <div>
                            <h5 class="modal-title text-primary fw-semibold">
                                <i class="bi bi-eye"></i> Detail Laporan
                            </h5>
                            <small class="text-muted">{{ $selectedIndikator->nama_indikator ?? '' }}</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Tanggal Laporan</label>
                                <p class="form-control-plaintext" id="detail_tanggal">-</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Tanggal Pengisian</label>
                                <p class="form-control-plaintext">
                                    <span class="fs-6 text-muted" id="detail_tanggal_pengisian">-</span>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Numerator</label>
                                <p class="form-control-plaintext" id="detail_numerator">-</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Denominator</label>
                                <p class="form-control-plaintext" id="detail_denominator">-</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Nilai</label>
                                <p class="form-control-plaintext">
                                    <span class="fs-6 text-muted" id="detail_nilai">-</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Status Pencapaian</label>
                                <p class="form-control-plaintext">
                                    <span class="badge" id="detail_pencapaian">-</span>
                                </p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-dark">File Laporan</label>
                            <p class="form-control-plaintext">
                                <a href="#" id="detail_file_link" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-arrow-down"></i> Lihat File
                                </a>
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-warning" onclick="openEditModal()">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL INPUT DATA (Tambah Baru) --}}
        <div class="modal fade" id="modalInputData" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius:14px;">
                    <div class="modal-header border-0">
                        <div>
                            <h5 class="modal-title text-success fw-semibold">+ Tambah Data Laporan</h5>
                            <small class="text-muted">{{ $selectedIndikator->nama_indikator ?? '' }}</small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="formInputData" method="POST" enctype="multipart/form-data"
                        action="{{ route('laporan-analis.store') }}">
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
                                <label class="form-label fw-semibold">Unggah File <span
                                        class="text-danger">*</span></label>
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

        <div class="modal fade" id="modalEditData" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:14px;">
            <div class="modal-header border-0">
                <h5 class="modal-title text-warning fw-semibold">
                    <i class="bi bi-pencil"></i> Edit Laporan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditData" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="table" id="edit_table">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Numerator</label>
                        <input type="number" name="numerator" id="edit_numerator"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Denominator</label>
                        <input type="number" name="denominator" id="edit_denominator"
                            class="form-control" required>
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
let currentTable = null;


        function handleDateClick(tanggalLaporan, sudahIsi, dataId, table) {
    currentTanggal = tanggalLaporan;
    currentDataId = dataId;
    currentTable = table;

    if (sudahIsi) {
        loadDetailData(dataId, table);
    } else {
        openInputModal(tanggalLaporan);
    }
}


        function openInputModal(tanggalLaporan) {
            document.getElementById('formInputData').reset();

            document.getElementById('modal_indikator_id').value = {{ $selectedIndikatorId ?? 'null' }};
            document.getElementById('modal_unit_id').value = {{ $selectedUnitId ?? 'null' }};
            document.getElementById('tanggal_laporan').value = tanggalLaporan;

            const tgl = new Date(tanggalLaporan);
            document.getElementById('tanggal_input_view').value = tgl.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            new bootstrap.Modal(document.getElementById('modalInputData')).show();
        }

        function loadDetailData(dataId, table) {
    fetch(`/laporan-analis/${dataId}/detail?table=${table}`)
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
                    document.getElementById('detail_tanggal').textContent = tgl.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });

                    document.getElementById('detail_numerator').textContent = data.numerator;
                    document.getElementById('detail_denominator').textContent = data.denominator;

                    const nilai = Number(data.nilai);
                    document.getElementById('detail_nilai').textContent =
                        (Number.isInteger(nilai) ? nilai : nilai.toFixed(1)) + '%';


                    const badgePencapaian = document.getElementById('detail_pencapaian');
                    if (data.pencapaian === 'tercapai') {
                        badgePencapaian.className = 'badge bg-success';
                        badgePencapaian.textContent = 'Tercapai';
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

    fetch(`/laporan-analis/${currentDataId}/detail?table=${currentTable}`)
        .then(res => res.json())
        .then(data => {

            document.getElementById('edit_numerator').value = data.numerator;
            document.getElementById('edit_denominator').value = data.denominator;

            // set table
            document.getElementById('edit_table').value = currentTable;

            const form = document.getElementById('formEditData');
            form.action = `/laporan-analis/${data.id}`;

            bootstrap.Modal.getInstance(
                document.getElementById('modalDetailData')
            ).hide();

            new bootstrap.Modal(
                document.getElementById('modalEditData')
            ).show();
        });
}



    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
