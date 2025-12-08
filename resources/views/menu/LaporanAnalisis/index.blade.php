@extends('layouts.app')

{{-- Title --}}
@section('title', 'Laporan dan Analisis')

{{-- Breadcrumb --}}
@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Laporan dan Analisis</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola laporan dan analisis dalam sistem.
            </p>
        </div>
        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
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
                            Laporan dan Analisis
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

{{-- Content --}}
@section('content')
    <section class="section">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Data Laporan & Analisis</h5>
            </div>

            <div class="card-body">

                <form class="row g-2 align-items-end mb-4" method="GET" action="">
                    <div class="col-md-2">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-control">
                            @foreach (range(1, 12) as $b)
                                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $b)->format('F') }}
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
                        <button class="btn btn-success w-100">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </form>

                {{-- Tabel --}}
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>INDIKATOR</th>
                                <th>PERIODE</th>
                                <th>UNIT</th>
                                <th>TARGET</th>
                                <th>NILAI</th>
                                <th>PENCAPAIAN</th>
                                <th>STATUS PERIODE</th>
                                <th>STATUS INDIKATOR</th>
                                <th>FILE</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $row->nama_indikator }}</td>

                                    <td>
                                        {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}
                                    </td>

                                    <td>{{ $row->nama_unit }}</td>

                                    <td>
                                        {{ $row->target_indikator !== null ? rtrim(rtrim($row->target_indikator, '0'), '.') . '%' : '-' }}
                                    </td>

                                    <td>
                                        @if($row->nilai !== null)
                                            @php
                                                $nilai = rtrim(rtrim($row->nilai, '0'), '.');
                                                $target = $row->target_indikator;
                                            @endphp
                                            <span @class([
                                                'bg-warning px-1 rounded' => $nilai < $target
                                            ])>
                                                {{ $nilai }}
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        @if (is_null($row->nilai))
                                            <span class="badge bg-secondary">BELUM ADA DATA</span>
                                        @else
                                            @if ($row->pencapaian == 'tercapai')
                                                <span class="badge bg-success">TERCAPAI</span>
                                            @else
                                                <span class="badge bg-danger">TIDAK TERCAPAI</span>
                                            @endif
                                        @endif
                                    </td>

                                    <td>
                                        <span class="badge {{ $row->status_periode == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                            {{ strtoupper($row->status_periode) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span
                                            class="badge {{ $row->status_indikator == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                            {{ strtoupper($row->status_indikator) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($row->file_laporan)
                                            <a href="{{ asset('storage/' . $row->file_laporan) }}" target="_blank"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td>
                                        {{-- Belum input nilai --}}
                                        @if (is_null($row->nilai))
                                            <button onclick="openInputModal({{ $row->id }}, {{ $row->unit_id }})"
                                                class="btn btn-success btn-sm">
                                                + Input Data
                                            </button>
                                        @else
                                            {{-- Nilai sudah ada --}}
                                            @if ($row->pencapaian === 'tidak-tercapai')

                                                {{-- Belum input PDSA --}}
                                                @if (is_null($row->pdsa_id))
                                                    <button onclick="openPDSAModal({{ $row->laporan_id }})" class="btn btn-warning btn-sm">
                                                        + Input PDSA
                                                    </button>
                                                @else
                                                    <span class="badge bg-info">
                                                        ✓ PDSA Sudah Diinput
                                                    </span>
                                                @endif

                                            @else
                                                <span class="badge bg-info">✓ Sudah Diinput</span>
                                            @endif
                                        @endif
                                    </td>


                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

        <div class="modal fade" id="modalInputData" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius: 14px;">

                    {{-- Header --}}
                    <div class="modal-header border-0">
                        <h5 class="modal-title" style="font-weight: 600; color:#0b7a60;">
                            + Tambah Data Indikator
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    {{-- Form --}}
                    <form id="formInputData" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body">

                            {{-- Bulan --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Bulan</label>
                                <select name="bulan" class="form-select" style="background: #f0f4f7; border-radius: 8px;"
                                    readonly disabled>
                                    <option value="{{ $bulan }}">
                                        {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                                    </option>
                                </select>
                                <input type="hidden" name="bulan" value="{{ $bulan }}">
                            </div>

                            {{-- Tahun --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tahun</label>
                                <select name="tahun" class="form-select" style="background: #f0f4f7; border-radius: 8px;"
                                    readonly disabled>
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                </select>
                                <input type="hidden" name="tahun" value="{{ $tahun }}">
                            </div>

                            {{-- Numerator --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Numerator <span style="color: red">*</span></label>
                                <input type="number" name="numerator" class="form-control" placeholder="Masukkan numerator"
                                    style="border-radius: 8px;" required>
                            </div>

                            {{-- Denominator --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Denominator <span style="color: red">*</span></label>
                                <input type="number" name="denominator" class="form-control"
                                    placeholder="Masukkan denominator" style="border-radius: 8px;" required>
                            </div>

                            {{-- Upload File --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Unggah File <span style="color: red">*</span></label>

                                <div class="p-4 text-center rounded"
                                    style="border: 2px dashed #c4d3de; background: #f8fafc;">
                                    <label for="file_laporan" class="w-100"
                                        style="cursor: pointer; color: #275f88; font-weight: 600;">
                                        <i class="bi bi-cloud-upload fs-4 d-block mb-2"></i>
                                        Pilih file untuk diunggah
                                    </label>
                                    <input type="file" id="file_laporan" name="file_laporan" class="d-none"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                                    <small class="text-muted d-block mt-2">
                                        Format diizinkan: PDF, DOC, DOCX, XLS, XLSX (Maks. 5MB)
                                    </small>
                                    <small id="selected-file" class="text-success mt-2 d-block"></small>
                                </div>
                            </div>

                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer border-0">

                            <button type="button" class="btn btn-light" data-bs-dismiss="modal"
                                style="border-radius: 8px; padding: 8px 20px;">
                                × Batal
                            </button>

                            <button type="submit" class="btn btn-success" style="border-radius: 8px; padding: 8px 20px;">
                                <i class="bi bi-check-circle me-1"></i> Simpan
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade" id="pdsaModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form action="{{ route('pdsa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="laporan_analisis_id" id="laporan_analisis_id">

                        <div class="modal-header">
                            <h5 class="modal-title">Input PDSA</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label>Plan <span style="color: red">*</span></label>
                                <textarea name="plan" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Do <span style="color: red">*</span></label>
                                <textarea name="do" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Study <span style="color: red">*</span></label>
                                <textarea name="study" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Act <span style="color: red">*</span></label>
                                <textarea name="act" class="form-control" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>File PDSA <span style="color: red">*</span></label>
                                <input type="file" name="file_pdsa" class="form-control" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </section>
@endsection

@push('js')
    <script>
        function openInputModal(indikator_id, unit_id) {
            const form = document.getElementById('formInputData');
            form.action = "{{ route('laporan-analisis.store') }}";

            // Hapus input hidden lama agar tidak menumpuk
            let oldUnit = form.querySelector('input[name="unit_id"]');
            if (oldUnit) oldUnit.remove();

            let oldIndikator = form.querySelector('input[name="indikator_id"]');
            if (oldIndikator) oldIndikator.remove();

            // Tambahkan hidden indikator_id
            let hiddenI = document.createElement("input");
            hiddenI.type = "hidden";
            hiddenI.name = "indikator_id";
            hiddenI.value = indikator_id;
            form.appendChild(hiddenI);

            // Tambahkan hidden unit_id
            let hiddenU = document.createElement("input");
            hiddenU.type = "hidden";
            hiddenU.name = "unit_id";
            hiddenU.value = unit_id;
            form.appendChild(hiddenU);

            // Reset info file setiap modal dibuka
            document.getElementById('selected-file').textContent = "";

            new bootstrap.Modal(document.getElementById('modalInputData')).show();
        }

        // Preview nama file setelah dipilih
        document.getElementById('file_laporan').addEventListener('change', function () {
            let fileName = this.files.length > 0 ? this.files[0].name : '';
            document.getElementById('selected-file').textContent = fileName;
        });

        function openPDSAModal(laporanID) {
            document.getElementById('laporan_analisis_id').value = laporanID;
            var modal = new bootstrap.Modal(document.getElementById('pdsaModal'));
            modal.show();
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush