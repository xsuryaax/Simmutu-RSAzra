@extends('layouts.app')

@section('title', 'Laporan dan Analisis')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5>Data Laporan & Analisis</h5>
            </div>

            <div class="card-body">

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Filter bulan & tahun saja --}}
                <form method="GET" class="row g-2 align-items-end mb-4">
                    <div class="col-md-2">
                        <label class="form-label">Bulan</label>
                        <select name="bulan" class="form-control">
                            @foreach(range(1, 12) as $b)
                                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                    {{ \DateTime::createFromFormat('!m', $b)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Tahun</label>
                        <select name="tahun" class="form-control">
                            @foreach(range(date('Y') - 5, date('Y') + 2) as $t)
                                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
                    </div>
                </form>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>INDIKATOR</th>
                                <th>PERIODE</th>
                                <th>UNIT</th>
                                <th>FREKUENSI</th>
                                <th>TARGET</th>
                                <th>NILAI</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->nama_indikator }}</td>
                                    <td>
                                        {{ $row->tanggal_laporan ? \Carbon\Carbon::parse($row->tanggal_laporan)->translatedFormat('d F Y') : '-' }}
                                    </td>

                                    <td>{{ $row->nama_unit }}</td>
                                    <td>{{ $row->nama_frekuensi }}</td>
                                    <td>
                                        {{ $row->target_indikator !== null ? rtrim(rtrim($row->target_indikator, '0'), '.') . '%' : '-' }}
                                    </td>
                                    <td>
                                        @php
                                            $nilaiTampil = $row->nilai;
                                        @endphp

                                        @if(!is_null($nilaiTampil))
                                            @php $nilai = rtrim(rtrim($nilaiTampil, '0'), '.'); @endphp
                                            {{ $nilai }}
                                        @else
                                            <span class="badge bg-secondary">Belum lengkap</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$row->boleh_input)
                                            {{-- alasan jika ada --}}
                                            <span class="badge bg-secondary">
                                                {{ $row->alasan_tidak_boleh ?? 'Sudah input' }}
                                            </span>
                                        @else
                                            <button class="btn btn-success btn-sm"
                                                onclick="openInputModal({{ $row->id }}, {{ $row->unit_id }})">
                                                + Input Data
                                            </button>
                                        @endif

                                        {{-- PDSA --}}
                                        @if($row->nilai !== null && $row->pencapaian === 'tidak-tercapai')
                                            @if(!$row->pdsa_exists)
                                                <button class="btn btn-warning btn-sm mt-1"
                                                    onclick="openPDSAModal({{ $row->laporan_id }})">
                                                    + Input PDSA
                                                </button>
                                            @else
                                                <div class="mt-1"><span class="badge bg-info">✓ PDSA Sudah Diinput</span></div>
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

        {{-- Modal Input Data (dipakai untuk semua indikator - hidden inputs diisi JS) --}}
        <div class="modal fade" id="modalInputData" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius:14px;">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" style="color:#0b7a60; font-weight:600;">+ Tambah Data Indikator</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form id="formInputData" method="POST" enctype="multipart/form-data"
                        action="{{ route('laporan-analisis.store') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="indikator_id" id="modal_indikator_id">
                            <input type="hidden" name="unit_id" id="modal_unit_id">
                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal</label>
                                <select name="tanggal_laporan" class="form-select" required>
                                    @php $selectedDay = date('d'); @endphp
                                    @for($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}" {{ $selectedDay == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Numerator <span class="text-danger">*</span></label>
                                <input type="number" name="numerator" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Denominator <span class="text-danger">*</span></label>
                                <input type="number" name="denominator" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Unggah File <span class="text-danger">*</span></label>
                                <input type="file" name="file_laporan" class="form-control"
                                    accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.png" required>
                                <small class="text-muted d-block mt-1">Format: PDF/DOC/XLS/JPG/PNG (Maks 5MB)</small>
                            </div>

                        </div>

                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">× Batal</button>
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal PDSA --}}
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
                            <div class="mb-3"><label>Plan *</label><textarea name="plan" class="form-control"
                                    required></textarea></div>
                            <div class="mb-3"><label>Do *</label><textarea name="do" class="form-control"
                                    required></textarea></div>
                            <div class="mb-3"><label>Study *</label><textarea name="study" class="form-control"
                                    required></textarea></div>
                            <div class="mb-3"><label>Act *</label><textarea name="act" class="form-control"
                                    required></textarea></div>
                            <div class="mb-3"><label>File PDSA *</label><input type="file" name="file_pdsa"
                                    class="form-control" required></div>
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
        function openInputModal(indikatorId, unitId) {
            document.getElementById('modal_indikator_id').value = indikatorId;
            document.getElementById('modal_unit_id').value = unitId;
            // reset form
            document.getElementById('formInputData').reset();
            new bootstrap.Modal(document.getElementById('modalInputData')).show();
        }

        function openPDSAModal(laporanId) {
            document.getElementById('laporan_analisis_id').value = laporanId || '';
            new bootstrap.Modal(document.getElementById('pdsaModal')).show();
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush