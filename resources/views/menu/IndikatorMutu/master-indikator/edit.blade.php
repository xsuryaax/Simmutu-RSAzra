@extends('layouts.app')

@section('title', 'Edit Data Indikator')

@section('page-title')
<div class="page-header">
    <div class="page-header-left">
        <h3>Edit Indikator</h3>
        <p class="text-subtitle text-muted">
            Halaman untuk mengelola indikator mutu dalam sistem.
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
                    Form Edit Master Indikator Mutu
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
                    <h4 class="card-title">Form Edit Indikator Mutu</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('master-indikator.update', $indikator->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- ================= NAMA INDIKATOR ================= --}}
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-4">
                                <label>Nama Indikator <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="nama_indikator"
                                    class="form-control @error('nama_indikator') is-invalid @enderror"
                                    value="{{ old('nama_indikator', $indikator->nama_indikator) }}" required>
                                @error('nama_indikator')
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
                                @if (in_array(auth()->user()->unit_id, [1, 2]))
                                    <select name="unit_id"
                                        class="form-control @error('unit_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Unit --</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ old('unit_id', $indikator->unit_id) == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input type="text" class="form-control"
                                        value="{{ auth()->user()->unit->nama_unit }}" readonly>
                                    <input type="hidden" name="unit_id"
                                        value="{{ auth()->user()->unit_id }}">
                                @endif
                                @error('unit_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- ================= TARGET ================= --}}
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-4">
                                <label>Target Indikator <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="target_indikator"
                                    class="form-control @error('target_indikator') is-invalid @enderror"
                                    value="{{ old('target_indikator', $indikator->target_indikator) }}" required>
                                @error('target_indikator')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- ================= TIPE INDIKATOR ================= --}}
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-4">
                                <label>Tipe Indikator <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-8">
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="radio" name="tipe_indikator" value="lokal"
                                            {{ old('tipe_indikator', $indikator->tipe_indikator) == 'lokal' ? 'checked' : '' }} required>
                                        <label class="form-check-label">Lokal</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="radio" name="tipe_indikator" value="nasional"
                                            {{ old('tipe_indikator', $indikator->tipe_indikator) == 'nasional' ? 'checked' : '' }}>
                                        <label class="form-check-label">Nasional</label>
                                    </div>
                                </div>
                                @error('tipe_indikator')
                                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        {{-- ================= STATUS ================= --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-md-4">
                                <label>Status Indikator <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-8 d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_indikator"
                                        value="aktif"
                                        {{ old('status_indikator', $indikator->status_indikator) == 'aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label">Aktif</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_indikator"
                                        value="non-aktif"
                                        {{ old('status_indikator', $indikator->status_indikator) == 'non-aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label">Non-Aktif</label>
                                </div>
                            </div>
                        </div>

                        {{-- ================= BUTTON ================= --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('master-indikator.index') }}" class="btn btn-light-secondary me-2">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
