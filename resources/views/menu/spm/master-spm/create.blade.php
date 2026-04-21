@extends('layouts.app')

@section('title', 'Tambah Data SPM')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Tambah SPM</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola spm mutu dalam sistem.
            </p>
        </div>

        <div class="page-header-right">
            <div class="d-flex justify-content-end align-items-center gap-3">
                <span class="greeting-card">
                    <strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong>
                </span>

                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>

            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end mt-2">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Form Tambah Master SPM
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    <section id="basic-vertical-layouts">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Form Tambah SPM</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('master-spm.store') }}" method="POST">
                            @csrf

                            {{-- ================= NAMA SPM ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Nama SPM <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_spm"
                                        class="form-control @error('nama_spm') is-invalid @enderror"
                                        value="{{ old('nama_spm') }}" required>
                                    @error('nama_spm')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- ================= UNIT ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Unit <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    @if ($units)
                                        <select name="unit_id" class="form-control" required>
                                            <option value="">-- Pilih Unit --</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">
                                                    {{ $unit->nama_unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="text" class="form-control" value="{{ $unitUser->nama_unit }}" readonly>
                                        <input type="hidden" name="unit_id" value="{{ $unitUser->id }}">
                                    @endif
                                </div>
                            </div>

                            {{-- ================= Kriteria Pencapaian ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Kriteria Pencapaian <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-8">
                                    <select name="arah_target" id="arah_target"
                                        class="form-control @error('arah_target') is-invalid @enderror" required>
                                        <option value="lebih_besar">Lebih Besar / Sama Dengan ( >= )</option>
                                        <option value="lebih_kecil">Lebih Kecil / Sama Dengan ( <= )</option>
                                        <option value="range">Range (Min - Max)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- ================= TARGET SINGLE ================= --}}
                            <div id="target_single">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-4">
                                        <label>Target SPM <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" name="target_spm"
                                            class="form-control @error('target_spm') is-invalid @enderror"
                                            value="{{ old('target_spm') }}" placeholder="Masukkan Target (%)">
                                        @error('target_spm')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- ================= TARGET RANGE ================= --}}
                            <div id="target_range" style="display: none;">

                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-4">
                                        <label>Target Minimum <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" name="target_min"
                                            class="form-control @error('target_min') is-invalid @enderror"
                                            value="{{ old('target_min') }}">
                                    </div>
                                </div>

                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-4">
                                        <label>Target Maksimum <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" name="target_max"
                                            class="form-control @error('target_max') is-invalid @enderror"
                                            value="{{ old('target_max') }}">
                                    </div>
                                </div>

                            </div>

                            {{-- ================= KETERANGAN ================= --}}
<div class="row mb-3 align-items-start">
    <div class="col-md-4">
        <label>Keterangan</label>
    </div>
    <div class="col-md-8">
        <textarea 
            name="keterangan"
            rows="1"
            class="form-control @error('keterangan') is-invalid @enderror"
            placeholder="Masukkan deskripsi / definisi spm (opsional)"
        >{{ old('keterangan') }}</textarea>

        @error('keterangan')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
        @enderror
    </div>
</div>

                            {{-- ================= STATUS SPM ================= --}}
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-4">
                                    <label>Status SPM <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-8 d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status_spm" id="status_aktif" value="aktif"
                                            checked>
                                        <label class="form-check-label" for="status_aktif">Aktif</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status_spm"
                                            value="non-aktif" id="status_nonaktif">
                                        <label class="form-check-label" for="status_nonaktif">Non-Aktif</label>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= BUTTON ================= --}}
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('master-spm.index') }}" class="btn btn-light-secondary me-2">
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Simpan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        function toggleTargetInput() {
            const arah = document.getElementById('arah_target').value;
            const single = document.getElementById('target_single');
            const range = document.getElementById('target_range');

            const targetSingle = document.querySelector('input[name="target_spm"]');
            const targetMin = document.querySelector('input[name="target_min"]');
            const targetMax = document.querySelector('input[name="target_max"]');

            if (arah === 'range') {
                single.style.display = 'none';
                range.style.display = 'block';

                targetSingle.removeAttribute('required');
                targetMin.setAttribute('required', true);
                targetMax.setAttribute('required', true);
            } else {
                single.style.display = 'block';
                range.style.display = 'none';

                targetSingle.setAttribute('required', true);
                targetMin.removeAttribute('required');
                targetMax.removeAttribute('required');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleTargetInput();
            document.getElementById('arah_target').addEventListener('change', toggleTargetInput);
        });
    </script>
@endpush