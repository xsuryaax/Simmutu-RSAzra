@extends('layouts.app')

@section('title', 'Tambah Data Indikator')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Tambah Indikator</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola indikator mutu dalam sistem.
            </p>
        </div>

        <div class="page-header-right">
            <div class="d-flex justify-content-end align-items-center gap-3">
                <span class="greeting-card">
                    <strong>👋 Hello, {{ Auth::user()->username }}</strong>
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
                        Form Tambah Master Indikator Mutu
                    </li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content')
    @php
        $user = Auth::user();
    @endphp

    <section id="basic-vertical-layouts">
        <div class="row match-height">

            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Form Tambah Indikator Mutu</h4>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('master-indikator.store') }}" method="POST">
                            @csrf

                            {{-- ================= NAMA INDIKATOR ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Nama Indikator</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="nama_indikator"
                                        class="form-control @error('nama_indikator') is-invalid @enderror"
                                        value="{{ old('nama_indikator') }}" required>
                                    @error('nama_indikator')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- ================= UNIT ================= --}}
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Unit</label>
                                </div>
                                <div class="col-md-8">

                                    {{-- ADMIN / MUTU --}}
                                    @if ($units)
                                        <select name="unit_id" class="form-control" required>
                                            <option value="">-- Pilih Unit --</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">
                                                    {{ $unit->nama_unit }}
                                                </option>
                                            @endforeach
                                        </select>

                                        {{-- USER BIASA --}}
                                    @else
                                        <input type="text" class="form-control" value="{{ $unitUser->nama_unit }}" readonly>

                                        <input type="hidden" name="unit_id" value="{{ $unitUser->id }}">
                                    @endif

                                </div>
                            </div>

                            {{-- ================= TARGET ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Target Indikator</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="target_indikator"
                                        class="form-control @error('target_indikator') is-invalid @enderror"
                                        value="{{ old('target_indikator') }}" required>
                                    @error('target_indikator')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- ================= TIPE INDIKATOR ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Tipe Indikator</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="tipe_indikator"
                                        class="form-control @error('tipe_indikator') is-invalid @enderror" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="lokal" {{ old('tipe_indikator') == 'lokal' ? 'selected' : '' }}>Lokal
                                        </option>
                                        <option value="nasional" {{ old('tipe_indikator') == 'nasional' ? 'selected' : '' }}>
                                            Nasional</option>
                                    </select>
                                    @error('tipe_indikator')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- ================= PERIODE TAHUN ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Periode Tahun</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="periode_tahun"
                                        class="form-control @error('periode_tahun') is-invalid @enderror"
                                        value="{{ old('periode_tahun') }}" required>
                                    @error('periode_tahun')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- ================= TANGGAL MULAI ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Tanggal Mulai</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="tanggal_mulai"
                                        class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        value="{{ old('tanggal_mulai') }}" required>
                                    @error('tanggal_mulai')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- ================= TANGGAL SELESAI ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Tanggal Selesai</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" name="tanggal_selesai"
                                        class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        value="{{ old('tanggal_selesai') }}" required>
                                    @error('tanggal_selesai')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- ================= STATUS PERIODE ================= --}}
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4">
                                    <label>Status Periode</label>
                                </div>
                                <div class="col-md-8 d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status_periode" value="aktif"
                                            checked>
                                        <label class="form-check-label">Aktif</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status_periode"
                                            value="non-aktif">
                                        <label class="form-check-label">Non-Aktif</label>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= STATUS INDIKATOR ================= --}}
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-4">
                                    <label>Status Indikator</label>
                                </div>
                                <div class="col-md-8 d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status_indikator" value="aktif"
                                            checked>
                                        <label class="form-check-label">Aktif</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status_indikator"
                                            value="non-aktif">
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