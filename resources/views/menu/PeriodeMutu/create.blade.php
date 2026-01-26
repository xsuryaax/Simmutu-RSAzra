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
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Periode</label>
                    <input type="text" name="nama_periode"
                        class="form-control @error('nama_periode') is-invalid @enderror"
                        placeholder="Contoh: Periode Mutu 2025"
                        value="{{ old('nama_periode') }}" required>
                    @error('nama_periode')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- TAHUN --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tahun</label>
                    <input type="number" name="tahun"
                        class="form-control @error('tahun') is-invalid @enderror"
                        value="{{ old('tahun', date('Y')) }}" required>
                    @error('tahun')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- TANGGAL MULAI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai"
                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                        value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- TANGGAL SELESAI --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai"
                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                        value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- STATUS --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Status</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                name="status" value="aktif" checked>
                            <label class="form-check-label">Aktif</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio"
                                name="status" value="non-aktif">
                            <label class="form-check-label">Non Aktif</label>
                        </div>
                    </div>
                </div>

                {{-- BUTTON --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('periode-mutu.index') }}" class="btn btn-light me-2">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</section>
@endsection
