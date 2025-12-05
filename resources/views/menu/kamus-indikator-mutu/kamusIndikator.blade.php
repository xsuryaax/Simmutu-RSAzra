@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Kamus Indikator Mutu</h3>
            <p class="text-subtitle text-muted">
                Data indikator mutu per unit di rumah sakit Azra
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
                            Kamus Indikator Mutu
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
            <div class="card-header">
                <h5 class="card-title">Kamus Indikator Mutu</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>INDIKATOR</th>
                                <th>PERIODE</th>
                                <th>UNIT</th>
                                <th>TARGET</th>
                                <th>NILAI</th>
                                <th>PENCAPAIAN</th>
                                <th>STATUS PERIODE</th>
                                <th>STATUS</th>
                                <th>FILE</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Respon time permintaan perbaikan</td>
                                <td>Desember 2025</td>
                                <td>SIMRS</td>
                                <td>-</td>
                                <td>-</td>
                                <td>BELUM ADA DATA</td>
                                <td>AKTIF</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <span class="btn btn-primary">+ Input Data</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
