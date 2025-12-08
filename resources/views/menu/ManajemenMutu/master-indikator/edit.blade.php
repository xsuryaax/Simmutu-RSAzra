@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Form Edit Master Indikator</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola master indikator dalam sistem.
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

                                <form action="{{ route('master-indikator.update', $indikator->id) }}" method="POST" class="form form-vertical">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-body">
                                        <div class="row">

                                            {{-- Nama Indikator --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="nama_indikator">Nama Indikator</label>
                                                <input type="text" id="nama_indikator" name="nama_indikator"
                                                    class="form-control @error('nama_indikator') is-invalid @enderror"
                                                    value="{{ old('nama_indikator', $indikator->nama_indikator) }}"
                                                    required>
                                                @error('nama_indikator')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- Unit --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="unit_id">Unit</label>
                                                <select id="unit_id" name="unit_id"
                                                    class="form-control @error('unit_id') is-invalid @enderror" required>
                                                    <option value="">-- Pilih Unit --</option>

                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}"
                                                            {{ old('unit_id', $indikator->unit_id) == $unit->id ? 'selected' : '' }}>
                                                            {{ $unit->nama_unit }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @error('unit_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- Target --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="target_indikator">Target</label>
                                                <input type="number" id="target_indikator" name="target_indikator"
                                                    class="form-control @error('target_indikator') is-invalid @enderror"
                                                    value="{{ old('target_indikator', $indikator->target_indikator) }}"
                                                    required>
                                                @error('target_indikator')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- Tipe Indikator --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="tipe_indikator">Tipe Indikator</label>
                                                <select id="tipe_indikator" name="tipe_indikator"
                                                    class="form-control @error('tipe_indikator') is-invalid @enderror" required>
                                                    <option value="">-- Pilih Tipe --</option>
                                                    <option value="lokal" {{ old('tipe_indikator', $indikator->tipe_indikator) == 'lokal' ? 'selected' : '' }}>Lokal</option>
                                                    <option value="nasional" {{ old('tipe_indikator', $indikator->tipe_indikator) == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                                </select>
                                                @error('tipe_indikator')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- Tanggal Mulai --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                                <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                                                    class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                                    value="{{ old('tanggal_mulai', $indikator->tanggal_mulai) }}" required>
                                                @error('tanggal_mulai')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- Tanggal Selesai --}}
                                            <div class="col-md-6 mb-3">
                                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                                <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                                                    class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                                    value="{{ old('tanggal_selesai', $indikator->tanggal_selesai) }}" required>
                                                @error('tanggal_selesai')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                            {{-- Status Periode --}}
                                            <div class="col-md-12 mb-3">
                                                <label>Status Periode</label>
                                                <div class="d-flex gap-4 mt-1">

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status_periode"
                                                            value="aktif"
                                                            {{ old('status_periode', $indikator->status_periode) == 'aktif' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Aktif</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status_periode"
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
                                                        <input class="form-check-input" type="radio" name="status_indikator"
                                                            value="aktif"
                                                            {{ old('status_indikator', $indikator->status_indikator) == 'aktif' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Aktif</label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="status_indikator"
                                                            value="non-aktif"
                                                            {{ old('status_indikator', $indikator->status_indikator) == 'non-aktif' ? 'checked' : '' }}>
                                                        <label class="form-check-label">Non-Aktif</label>
                                                    </div>

                                                </div>
                                            </div>

                                            {{-- Tombol --}}
                                            <div class="col-12 d-flex justify-content-end">
                                                <a href="{{ route('master-indikator.index') }}" class="btn btn-light-secondary me-2">
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