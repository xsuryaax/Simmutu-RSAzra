@extends('layouts.app')

@section('title', 'Edit Profil Indikator Mutu')

@php
    $dimensiSelected = explode(',', $data->dimensi_mutu_id ?? '');
@endphp

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Edit Profil Indikator Mutu</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola profil indikator mutu dalam sistem.
            </p>
        </div>
        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
                    <span class="greeting-card"><strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong></span>
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
                            Form Edit Profil Indikator Mutu
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section id="basic-vertical-layouts" class="overflow-hidden">
        <div class="row match-height">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Edit Profil Indikator Mutu</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            <form action="{{ route('kamus-indikator.update', $data->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="position-relative">

                                                <div class="vertical-line" style="left: 25%; z-index: 1;"></div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">
                                                            Judul Indikator <span class="text-danger">*</span>
                                                        </label>
                                                    </div>

                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <input type="text"
                                                            class="form-control right-input"
                                                            value="{{ $data->nama_indikator }}"
                                                            readonly>
                                                        <input type="hidden" name="indikator_id" value="{{ $data->indikator_id }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Unit</label>
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <input type="text"
                                                            class="form-control right-input"
                                                            value="{{ $data->nama_unit }}"
                                                            readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                @php $kategoriSelected = explode(',', $data->kategori_indikator); @endphp

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">
                                                            Kategori Indikator <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4 d-flex flex-wrap gap-2">
                                                        @foreach (['Prioritas Unit', 'Nasional', 'Prioritas RS'] as $kategori)
                                                            @php($id = 'kategori_' . strtolower(str_replace(' ', '_', $kategori)))
                                                            <input type="checkbox"
                                                                class="btn-check kategori-indikator right-input"
                                                                name="kategori_indikator[]" id="{{ $id }}"
                                                                value="{{ $kategori }}"
                                                                {{ in_array($kategori, $kategoriSelected) ? 'checked' : '' }}>
                                                            <label class="btn btn-outline-primary"
                                                                for="{{ $id }}">
                                                                {{ $kategori }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div id="kategoriImprsWrapper" class="d-none col-md-12 add-input mb-3">
                                                        <div class="col-12 col-md-3">
                                                            <label class="form-label left-input text-nowrap">
                                                                Kategori IMPRS <span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                        <div class="col-12 col-md-9 ps-md-4">
                                                            <select name="kategori_id" class="form-select right-input">
                                                                <option value="">Pilih Kategori IMPRS</option>
                                                                @foreach ($kategoriImprs as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ $item->id == $data->kategori_id ? 'selected' : '' }}>
                                                                        {{ $item->nama_kategori_imprs }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Dasar Pemikiran
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="dasar_pemikiran" class="form-control right-input" rows="3" required>{{ old('dasar_pemikiran', $data->dasar_pemikiran) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Dimensi Mutu <span
                                                                class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <div class="right-input">
                                                            @foreach ($dimensi as $d)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        name="dimensi_mutu_id[]"
                                                                        value="{{ $d->id }}"
                                                                        id="dimensi_{{ $d->id }}"
                                                                        {{ in_array($d->id, $dimensiSelected) ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="dimensi_{{ $d->id }}">
                                                                        {{ $d->nama_dimensi_mutu }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Tujuan <span
                                                                class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="tujuan" class="form-control right-input" rows="4" required>{{ old('tujuan', $data->tujuan) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Definisi
                                                            Operasional
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="definisi_operasional" class="form-control right-input" rows="4" required>{{ old('definisi_operasional', $data->definisi_operasional) }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Jenis Indikator
                                                            <span class="text-danger">*</span></label><br>
                                                    </div>

                                                    <div class="col-12 col-md-9 ps-md-4 d-flex flex-wrap gap-2">
                                                        @foreach ($jenisIndikator as $item)
                                                            @php($id = 'jenis_' . $item->id)

                                                            <input type="radio" class="btn-check right-input"
                                                                name="jenis_indikator_id" id="{{ $id }}"
                                                                value="{{ $item->id }}" required
                                                                {{ $item->id == $data->jenis_indikator_id ? 'checked' : '' }}>

                                                            <label class="btn btn-outline-primary"
                                                                for="{{ $id }}">
                                                                {{ $item->nama_jenis_indikator }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Satuan Pengukuran
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="satuan_pengukuran" class="form-control right-input" rows="1" required>{{ old('satuan_pengukuran', $data->satuan_pengukuran) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Numerator
                                                            (Pembilang)
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="numerator" class="form-control right-input" rows="1" required>{{ old('numerator', $data->numerator) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Denominator
                                                            (Penyebut)
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="denominator" class="form-control right-input" rows="1" required>{{ old('denominator', default: $data->denominator) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Target Pencapaian
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="target_pencapaian" class="form-control right-input" rows="1" required>{{ old('target_pencapaian', $data->target_pencapaian) }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Kriteria Inklusi
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="kriteria_inklusi" class="form-control right-input" rows="3" required>{{ old('kriteria_inklusi', $data->kriteria_inklusi) }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Kriteria Eksklusi
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="kriteria_eksklusi" class="form-control right-input" rows="3" required>{{ old('kriteria_eksklusi', $data->kriteria_eksklusi) }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Formula<span
                                                                class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="formula" class="form-control right-input" rows="3" required>{{ old('formula', default: $data->formula) }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Metode Pengumpulan
                                                            Data <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="metode_pengumpulan_data" class="form-control right-input" rows="3" required>{{ old('metode_pengumpulan_data', $data->metode_pengumpulan_data) }}
                                                        </textarea>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Sumber Data <span
                                                                class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="sumber_data" class="form-control right-input" rows="3" required>{{ old('sumber_data', $data->sumber_data) }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Instrumen
                                                            Pengambilan
                                                            Data <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="instrumen_pengambilan_data" class="form-control right-input" rows="2" required>{{ old('instrumen_pengambilan_data', $data->instrumen_pengambilan_data) }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-wrap">
                                                            Populasi<span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="populasi" class="form-control right-input" rows="2" required>{{ old('populasi', $data->populasi) }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-wrap">
                                                            Sampel<span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="sampel" class="form-control right-input" rows="2" required>{{ old('sampel', $data->sampel) }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">
                                                            Periode Pengumpulan Data <span class="text-danger">*</span>
                                                        </label>
                                                    </div>

                                                    <div class="col-12 col-md-9 ps-md-4 d-flex flex-wrap gap-2">
                                                        @foreach ($periodePengumpulan as $item)
                                                            @php($id = 'pengumpulan_' . $item->id)
                                                            <input type="radio" class="btn-check"
                                                                name="periode_pengumpulan_data_id"
                                                                id="{{ $id }}" value="{{ $item->id }}"
                                                                required
                                                                {{ $item->id == $data->periode_pengumpulan_data_id ? 'checked' : '' }}>
                                                            <label class="btn btn-outline-primary"
                                                                for="{{ $id }}">
                                                                {{ $item->nama_periode_pengumpulan_data }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">
                                                            Periode Analisis & Pelaporan Data <span
                                                                class="text-danger">*</span>
                                                        </label>
                                                    </div>

                                                    <div class="col-12 col-md-9 ps-md-4 d-flex flex-wrap gap-2">
                                                        @foreach ($periodeAnalisis as $item)
                                                            @php($id = 'analisis_' . $item->id)
                                                            <input type="radio" class="btn-check"
                                                                name="periode_analisis_data_id" id="{{ $id }}"
                                                                value="{{ $item->id }}" required
                                                                {{ $item->id == $data->periode_analisis_data_id ? 'checked' : '' }}>

                                                            <label class="btn btn-outline-primary"
                                                                for="{{ $id }}">
                                                                {{ $item->nama_periode_analisis_data }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Penyajian Data
                                                            <span class="text-danger">*</span></label><br>
                                                    </div>

                                                    <div class="col-12 col-md-9 ps-md-4 d-flex flex-wrap gap-2">
                                                        @foreach ($penyajianData as $item)
                                                            @php($id = 'penyajian_' . $item->id)
                                                            <input type="radio" class="btn-check right-input"
                                                                name="penyajian_data_id" id="{{ $id }}"
                                                                value="{{ $item->id }}"
                                                                {{ $item->id == $data->penyajian_data_id ? 'checked' : '' }}
                                                                required>
                                                            <label class="btn btn-outline-primary"
                                                                for="{{ $id }}">
                                                                {{ $item->nama_penyajian_data }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3 add-input">
                                                    <div class="col-12 col-md-3">
                                                        <label class="form-label left-input text-nowrap">Penanggung Jawab
                                                            <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-12 col-md-9 ps-md-4">
                                                        <textarea name="penanggung_jawab" class="form-control right-textarea" rows="1"
                                                            placeholder="Isi penanggung jawab..." required>{{ old('penanggung_jawab', $data->penanggung_jawab) }}</textarea>
                                                    </div>
                                                </div>
                                            </>
                                        </div>
                                    </div>
                                </div>
                                <div class="ms-4 pb-4">
                                    <button class="btn btn-primary">Update</button>
                                    <a href="{{ route('kamus-indikator.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const indikatorCheckbox = document.querySelectorAll('.kategori-indikator');
            const kategoriWrapper = document.getElementById('kategoriImprsWrapper');

            function toggleKategori() {
                let isPrioritasRS = false;

                indikatorCheckbox.forEach(cb => {
                    if (cb.checked && cb.value === 'Prioritas RS') {
                        isPrioritasRS = true;
                    }
                });

                kategoriWrapper.classList.toggle('d-none', !isPrioritasRS);
            }

            indikatorCheckbox.forEach(cb => {
                cb.addEventListener('change', toggleKategori);
            });

            toggleKategori();
        });
    </script>
@endpush
