@extends('layouts.app')

@section('title', 'Edit Indikator Mutu Nasional')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Form Edit Indikator Mutu Nasional</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola master indikator mutu nasional dalam sistem.
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
                            Form Edit Master Indikator
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
<section id="basic-vertical-layouts">
    <div class="row match-height">
        <div class="col-md-12 col-12">
            <div class="card">

                <div class="card-header">
                    <h4 class="card-title">Form Edit Indikator</h4>
                </div>

                <div class="card-content">
                    <div class="card-body">

                        <form action="{{ route('master-imn.update', $indikator->id) }}"
                              method="POST" class="form form-vertical">
                            @csrf
                            @method('PUT')

                            <div class="form-body">
                                <div class="row">

                                    {{-- Nama Indikator --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="nama_indikator_nasional">Nama Indikator</label>
                                        <input type="text"
                                               id="nama_indikator_nasional"
                                               name="nama_indikator_nasional"
                                               class="form-control @error('nama_indikator_nasional') is-invalid @enderror"
                                               value="{{ old('nama_indikator_nasional', $indikator->nama_indikator_nasional) }}"
                                               required>
                                        @error('nama_indikator_nasional')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Target --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="target_indikator_nasional">Target</label>
                                        <input type="number"
                                               id="target_indikator_nasional"
                                               name="target_indikator_nasional"
                                               class="form-control @error('target_indikator_nasional') is-invalid @enderror"
                                               value="{{ old('target_indikator_nasional', $indikator->target_indikator_nasional) }}"
                                               required>
                                        @error('target_indikator_nasional')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Periode Tahun --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="periode_tahun">Periode Tahun</label>
                                        <input type="number"
                                               id="periode_tahun"
                                               name="periode_tahun"
                                               class="form-control @error('periode_tahun') is-invalid @enderror"
                                               value="{{ old('periode_tahun', $indikator->periode_tahun) }}"
                                               required>
                                        @error('periode_tahun')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Tanggal Mulai --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_mulai">Tanggal Mulai</label>
                                        <input type="date"
                                               id="tanggal_mulai"
                                               name="tanggal_mulai"
                                               class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                               value="{{ old('tanggal_mulai', $indikator->tanggal_mulai) }}"
                                               required>
                                        @error('tanggal_mulai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Tanggal Selesai --}}
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_selesai">Tanggal Selesai</label>
                                        <input type="date"
                                               id="tanggal_selesai"
                                               name="tanggal_selesai"
                                               class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                               value="{{ old('tanggal_selesai', $indikator->tanggal_selesai) }}"
                                               required>
                                        @error('tanggal_selesai')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Status Periode --}}
                                    <div class="col-md-12 mb-3">
                                        <label>Status Periode</label>
                                        <div class="d-flex gap-4 mt-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="status_periode"
                                                       value="aktif"
                                                       {{ old('status_periode', $indikator->status_periode) == 'aktif' ? 'checked' : '' }}>
                                                <label class="form-check-label">Aktif</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="status_periode"
                                                       value="non-aktif"
                                                       {{ old('status_periode', $indikator->status_periode) == 'non-aktif' ? 'checked' : '' }}>
                                                <label class="form-check-label">Non-Aktif</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Status Indikator --}}
                                    <div class="col-md-12 mb-3">
                                        <label>Status Indikator</label>
                                        <div class="d-flex gap-4 mt-1">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="status_indikator_nasional"
                                                       value="aktif"
                                                       {{ old('status_indikator_nasional', $indikator->status_indikator_nasional) == 'aktif' ? 'checked' : '' }}>
                                                <label class="form-check-label">Aktif</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="status_indikator_nasional"
                                                       value="non-aktif"
                                                       {{ old('status_indikator_nasional', $indikator->status_indikator_nasional) == 'non-aktif' ? 'checked' : '' }}>
                                                <label class="form-check-label">Non-Aktif</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('master-imn.index') }}"
                                           class="btn btn-light-secondary me-2">
                                            Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i> Update
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
