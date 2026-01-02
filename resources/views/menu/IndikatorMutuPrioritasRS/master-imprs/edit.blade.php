@extends('layouts.app')

{{-- Title --}}
@section('title', 'Form Edit IMPRS')

{{-- Page Header --}}
@section('page-title')
<div class="page-header">
    <div class="page-header-left">
        <h3>Form Edit Indikator Mutu Prioritas Rumah Sakit</h3>
        <p class="text-subtitle text-muted">
            Halaman untuk mengubah master indikator mutu prioritas RS.
        </p>
    </div>

    <div class="page-header-right">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('/') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('master-imprs.index') }}">Master IMPRS</a>
                </li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

{{-- Content --}}
@section('content')
<section id="basic-vertical-layouts">
<div class="row match-height">
<div class="col-md-12">

<div class="card">

    {{-- Card Header --}}
    <div class="card-header">
        <h4 class="card-title mb-0">Form Edit Indikator Mutu Prioritas RS</h4>
    </div>

    {{-- Card Body --}}
    <div class="card-body">

        <form action="{{ route('master-imprs.update', $imprs->id) }}"
              method="POST"
              class="form form-vertical">
            @csrf
            @method('PUT')

            <div class="form-body">
                <div class="row">

                    {{-- Nama Indikator --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Indikator</label>
                        <input type="text"
                               name="nama_imprs"
                               class="form-control"
                               value="{{ old('nama_imprs', $imprs->nama_imprs) }}"
                               required>
                    </div>

                    {{-- Kategori --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id"
                                class="form-control"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori_id', $imprs->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori_imprs }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Target --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Target</label>
                        <input type="number"
                               name="target_imprs"
                               class="form-control"
                               value="{{ old('target_imprs', $imprs->target_imprs) }}"
                               required>
                    </div>

                    {{-- Tipe Indikator --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipe Indikator</label>
                        <select name="tipe_imprs"
                                class="form-control"
                                required>
                            <option value="lokal"
                                {{ old('tipe_imprs', $imprs->tipe_imprs) == 'lokal' ? 'selected' : '' }}>
                                Lokal
                            </option>
                            <option value="nasional"
                                {{ old('tipe_imprs', $imprs->tipe_imprs) == 'nasional' ? 'selected' : '' }}>
                                Nasional
                            </option>
                        </select>
                    </div>

                    {{-- Periode Tahun --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Periode Tahun</label>
                        <input type="number"
                               name="periode_tahun"
                               class="form-control"
                               value="{{ old('periode_tahun', $imprs->periode_tahun) }}"
                               required>
                    </div>

                    {{-- Tanggal Mulai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date"
                               name="tanggal_mulai"
                               class="form-control"
                               value="{{ old('tanggal_mulai', $imprs->tanggal_mulai) }}"
                               required>
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date"
                               name="tanggal_selesai"
                               class="form-control"
                               value="{{ old('tanggal_selesai', $imprs->tanggal_selesai) }}"
                               required>
                    </div>

                    {{-- Status Periode --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Status Periode</label>
                        <div class="d-flex gap-4 mt-1">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status_periode"
                                       value="aktif"
                                       {{ old('status_periode', $imprs->status_periode) == 'aktif' ? 'checked' : '' }}>
                                <label class="form-check-label">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status_periode"
                                       value="non-aktif"
                                       {{ old('status_periode', $imprs->status_periode) == 'non-aktif' ? 'checked' : '' }}>
                                <label class="form-check-label">Non-Aktif</label>
                            </div>
                        </div>
                    </div>

                    {{-- Status Indikator --}}
                    <div class="col-md-12 mb-4">
                        <label class="form-label">Status Indikator</label>
                        <div class="d-flex gap-4 mt-1">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status_imprs"
                                       value="aktif"
                                       {{ old('status_imprs', $imprs->status_imprs) == 'aktif' ? 'checked' : '' }}>
                                <label class="form-check-label">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="radio"
                                       name="status_imprs"
                                       value="non-aktif"
                                       {{ old('status_imprs', $imprs->status_imprs) == 'non-aktif' ? 'checked' : '' }}>
                                <label class="form-check-label">Non-Aktif</label>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="col-12 d-flex justify-content-end">
                        <a href="{{ route('master-imprs.index') }}"
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
</section>
@endsection
