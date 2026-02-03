@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Master Indikator')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Master Indikator Mutu</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola master indikator mutu dalam sistem.
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
                            Master Indikator Mutu
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Data Indikator Mutu</h5>

                <a href="{{ route('master-indikator.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
            </div>

            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    @php
                        $isAdminMutu = in_array(auth()->user()->unit_id, [1, 2]);
                    @endphp

                    @if ($isAdminMutu)
                        <form method="GET" action="{{ route('master-indikator.index') }}" class="row g-2 mb-3">
                            <div class="col-md-4">
                                <select name="unit_id" class="form-select">
                                    <option value="">-- Semua Unit --</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}"
                                            {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                            {{ $unit->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-auto">
                                <button class="btn btn-primary">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                        </form>
                    @endif

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th>INDIKATOR</th>
                                <th class="text-center">TARGET</th>
                                <th class="text-center">TIPE</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($indikators as $i => $row)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td class="">{{ $row->nama_indikator }}</td>

                                    <td class="text-center">{{ rtrim(rtrim($row->target_indikator, '0'), '.') }}%</td>
                                    <td class="text-center">
                                        <span>{{ ucfirst($row->tipe_indikator) }}</span>
                                    </td>

                                    <td class="text-center">
                                        @if ($row->status_indikator == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('master-indikator.edit', $row->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
