@php
    $user = auth()->user();
@endphp

@extends('layouts.app')

@section('title', 'Edit Data Indikator')

@section('page-title')
<div class="page-header">
    <div class="page-header-left">
        <h3>Form Edit Master Indikator Mutu</h3>
        <p class="text-subtitle text-muted">
            Halaman untuk mengelola master indikator mutu dalam sistem.
        </p>
    </div>
    <div class="page-header-right">
        <div class="justify-content-end d-flex">
            <form method="POST" action="/logout">
                <span class="greeting-card"><strong>👋 Hello, {{ $user->unit->nama_unit }}</strong></span>
                @csrf
                <button type="submit" class="btn btn-primary logout-btn">
                    <i class="bi bi-box-arrow-right"></i> Logout
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
                        Form Edit Master Indikator Mutu
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Edit Indikator Mutu</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('master-indikator.update', $indikator->id) }}" method="POST" class="form form-horizontal">
                            @csrf
                            @method('PUT')

                            <div class="form-body">
                                <div class="row">

                                    {{-- Nama Indikator --}}
                                    <div class="col-md-4">
                                        <label for="nama_indikator">Nama Indikator</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <input type="text" id="nama_indikator" name="nama_indikator"
                                            class="form-control @error('nama_indikator') is-invalid @enderror"
                                            value="{{ old('nama_indikator', $indikator->nama_indikator) }}" required>
                                        @error('nama_indikator')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Unit --}}
                                    <div class="col-md-4">
                                        <label for="unit_id">Unit</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        @if (in_array($user->unit_id, [1, 2]))
                                            <select id="unit_id" name="unit_id" class="form-control @error('unit_id') is-invalid @enderror" required>
                                                <option value="">-- Pilih Unit --</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}"
                                                        {{ old('unit_id', $indikator->unit_id) == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->nama_unit }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="text" class="form-control" value="{{ $units->first()->nama_unit }}" readonly>
                                            <input type="hidden" name="unit_id" value="{{ $units->first()->id }}">
                                        @endif
                                        @error('unit_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Target --}}
                                    <div class="col-md-4">
                                        <label for="target_indikator">Target</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <input type="number" id="target_indikator" name="target_indikator"
                                            class="form-control @error('target_indikator') is-invalid @enderror"
                                            value="{{ old('target_indikator', $indikator->target_indikator) }}" required>
                                        @error('target_indikator')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Tipe Indikator --}}
                                    <div class="col-md-4">
                                        <label for="tipe_indikator">Tipe Indikator</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <select id="tipe_indikator" name="tipe_indikator" class="form-control @error('tipe_indikator') is-invalid @enderror" required>
                                            <option value="">-- Pilih Tipe --</option>
                                            <option value="lokal" {{ old('tipe_indikator', $indikator->tipe_indikator) == 'lokal' ? 'selected' : '' }}>Lokal</option>
                                            <option value="nasional" {{ old('tipe_indikator', $indikator->tipe_indikator) == 'nasional' ? 'selected' : '' }}>Nasional</option>
                                        </select>
                                        @error('tipe_indikator')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- Status Indikator --}}
                                    <div class="col-md-4">
                                        <label>Status Indikator</label>
                                    </div>
                                    <div class="col-md-8 mb-3 d-flex gap-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_indikator" value="aktif"
                                                {{ old('status_indikator', $indikator->status_indikator) == 'aktif' ? 'checked' : '' }}>
                                            <label class="form-check-label">Aktif</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status_indikator" value="non-aktif"
                                                {{ old('status_indikator', $indikator->status_indikator) == 'non-aktif' ? 'checked' : '' }}>
                                            <label class="form-check-label">Non-Aktif</label>
                                        </div>
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8 d-flex justify-content-end">
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