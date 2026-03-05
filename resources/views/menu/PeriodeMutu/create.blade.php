@extends('layouts.app')

@section('title', 'Tambah Periode Mutu')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Tambah Periode Mutu</h3>
            <p class="text-subtitle text-muted">
                Menentukan periode global laporan indikator mutu.
            </p>
        </div>
    </div>
@endsection

@section('content')
<section class="section">
    <div class="card">
        <div class="card-body">

            <form action="{{ route('periode-mutu.store') }}" method="POST">
                @csrf

                {{-- NAMA PERIODE --}}
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">
                        Nama Periode
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="nama_periode"
                            class="form-control @error('nama_periode') is-invalid @enderror"
                            placeholder="Masukkan Nama Periode . . ."
                            value="{{ old('nama_periode') }}" required>
                        @error('nama_periode')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- TAHUN --}}
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">
                        Tahun
                    </label>
                    <div class="col-md-9">
                        <input type="number" name="tahun"
                            class="form-control @error('tahun') is-invalid @enderror"
                            value="{{ old('tahun', date('Y')) }}" required>
                        @error('tahun')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- TANGGAL MULAI --}}
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">
                        Tanggal Mulai
                    </label>
                    <div class="col-md-9">
                        <input type="date" name="tanggal_mulai"
                            class="form-control @error('tanggal_mulai') is-invalid @enderror"
                            value="{{ old('tanggal_mulai') }}" required>
                        @error('tanggal_mulai')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- TANGGAL SELESAI --}}
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">
                        Tanggal Selesai
                    </label>
                    <div class="col-md-9">
                        <input type="date" name="tanggal_selesai"
                            class="form-control @error('tanggal_selesai') is-invalid @enderror"
                            value="{{ old('tanggal_selesai') }}" required>
                        @error('tanggal_selesai')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- STATUS DEADLINE --}}
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-semibold">
                        Status Deadline
                    </label>
                    <div class="col-md-9">
                        <div class="d-flex gap-4 pt-2">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status_deadline"
                                       value="1"
                                       {{ old('status_deadline', 1) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status_deadline"
                                       value="0"
                                       {{ old('status_deadline') == 0 ? 'checked' : '' }}>
                                <label class="form-check-label">Non Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DEADLINE INPUT --}}
                <div class="row mb-3" id="deadlineField">
                    <label class="col-md-3 col-form-label fw-semibold">
                        Deadline Pengisian
                    </label>
                    <div class="col-md-9">
                        <input type="number" name="deadline"
                            class="form-control @error('deadline') is-invalid @enderror"
                            min="1" max="31"
                            value="{{ old('deadline') }}" placeholder="Contoh: 5">
                        @error('deadline')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- UNIT DEADLINE EXCEPTION --}}
                <div class="row mb-3" id="exceptionSection">
                    <label class="col-md-3 col-form-label fw-semibold">
                        Unit Bebas Deadline
                    </label>
                    <div class="col-md-9">

                        <p class="text-muted small mb-2">
                            Unit yang dipilih tidak mengikuti batas deadline periode ini.
                        </p>

                        <div class="row">
                            @foreach($units as $unit)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="unit_exception[]"
                                               value="{{ $unit->id }}"
                                               {{ in_array($unit->id, old('unit_exception', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $unit->nama_unit }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

                {{-- STATUS --}}
                <div class="row mb-4">
                    <label class="col-md-3 col-form-label fw-semibold">
                        Status Periode
                    </label>
                    <div class="col-md-9">
                        <div class="d-flex gap-4 pt-2">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status"
                                       value="aktif"
                                       checked>
                                <label class="form-check-label">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status"
                                       value="non-aktif">
                                <label class="form-check-label">Non Aktif</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="row">
                    <div class="d-flex justify-content-end mt-4">
    <a href="{{ route('periode-mutu.index') }}" class="btn btn-light me-2">
        Kembali
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle"></i> Simpan
    </button>
</div>
                </div>

            </form>

        </div>
    </div>
</section>
@endsection

@push('js')
<script>
    function toggleDeadline() {
        let selected = document.querySelector('input[name="status_deadline"]:checked');
        let deadlineField = document.getElementById('deadlineField');
        let exceptionSection = document.getElementById('exceptionSection');
        let deadlineInput = document.querySelector('input[name="deadline"]');

        if (!selected) return;

        if (selected.value == 1) {
            deadlineField.style.display = 'flex';
            exceptionSection.style.display = 'flex';
            deadlineInput.disabled = false;
        } else {
            deadlineField.style.display = 'none';
            exceptionSection.style.display = 'none';
            deadlineInput.disabled = true;
            deadlineInput.value = '';

            document.querySelectorAll('input[name="unit_exception[]"]').forEach(cb => {
                cb.checked = false;
            });
        }
    }

    document.querySelectorAll('input[name="status_deadline"]').forEach(radio => {
        radio.addEventListener('change', toggleDeadline);
    });

    window.onload = toggleDeadline;
</script>
@endpush