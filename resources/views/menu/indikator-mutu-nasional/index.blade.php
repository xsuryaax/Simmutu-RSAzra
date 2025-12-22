@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Indikator Mutu Nasional</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola Indikator Mutu Nasional dalam sistem.
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
                            Indikator Mutu Nasional
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

{{-- Bagian Konten Utama --}}
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-3">
                <h5 class="card-title mb-0">Indikator Mutu Nasional</h5>

                <a href="{{ route('indikator-mutu-nasional.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive table-dark">
                    <form method="GET" class="row g-2 align-items-end mb-4">
                        <div class="col-md-2">
                            <label class="form-label">Bulan</label>
                            <select name="bulan" class="form-control">
                                {{-- @foreach (range(1, 12) as $b)
                                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                        {{ \DateTime::createFromFormat('!m', $b)->format('F') }}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Tahun</label>
                            <select name="tahun" class="form-control">
                                {{-- @foreach (range(date('Y') - 5, date('Y') + 2) as $t)
                                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                                        {{ $t }}
                                    </option>
                                @endforeach --}}
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Filter</button>
                        </div>
                    </form>

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th style="width: 300px;">INDIKATOR</th>
                                <th>STANDAR</th>
                                <th>NUMERATOR</th>
                                <th>DENUMERATOR</th>
                                <th>HASIL</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
