@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Master IMPU')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Master Indikator Mutu Prioritas Unit</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola master indikator mutu prioritas unit dalam sistem.
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
                            Master Indikator Mutu Prioritas Unit
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
                <h5>Data Indikator Mutu Prioritas Unit</h5>

                <a href="{{ route('master-impu.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus"></i> Tambah Data
                </a>
            </div>

            <div class="card-body">
                <div class="table-parent-container table-responsive-md table-dark">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Unit</th>
                                <th>Target</th>
                                <th>Tipe</th>
                                <th>Periode</th>
                                <th>Rentang Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($indikators as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>{{ $row->nama_indikator_unit }}</td>

                                    <td>{{ $row->nama_unit ?? '-' }}</td>

                                    <td>{{ rtrim(rtrim($row->target_indikator_unit, '0'), '.') }}%</td>

                                    <td>
                                        <span class="badge bg-info">{{ ucfirst($row->tipe_indikator_unit) }}</span>
                                    </td>

                                    <td>
                                        {{ $row->periode_tahun }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($row->tanggal_mulai)->format('j') }} -
                                        {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('j') }}
                                    </td>

                                    <td>
                                        @if ($row->status_indikator_unit == 'aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Non-Aktif</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('master-impu.edit', $row->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('master-impu.destroy', $row->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Hapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
