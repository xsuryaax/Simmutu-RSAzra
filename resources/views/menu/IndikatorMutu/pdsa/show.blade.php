@extends('layouts.app')

@section('title', 'Detail PDSA')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>DETAIL PDSA</h3>
            <p class="text-subtitle text-muted">
                Daftar indikator mutu yang tidak tercapai dan memerlukan PDSA
            </p>
        </div>

        <div class="page-header-right">
            <div class="justify-content-end d-flex">
                <form method="POST" action="/logout">
                    <span class="greeting-card">
                        <strong>👋 Hello, {{ Auth::user()->unit->nama_unit }}</strong>
                    </span>
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
                            PDSA
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section id="pdsa-detail">
        <div class="row">

            {{-- INFO --}}
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">

                        <div class="row mb-2">
                            <div class="col-md-4 fw-semibold">Periode</div>
                            <div class="col-md-8">
                                : {{ $pdsa->quarter }} {{ $pdsa->tahun }}
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-4 fw-semibold">Status</div>
                            <div class="col-md-8"> :
                                <span class="badge
                                        @if($pdsa->status_pdsa == 'assigned') bg-warning
                                        @elseif($pdsa->status_pdsa == 'submitted') bg-info
                                        @elseif($pdsa->status_pdsa == 'approved') bg-success
                                        @endif">
                                    @if($pdsa->status_pdsa == 'assigned')
                                        Ditugaskan
                                    @elseif($pdsa->status_pdsa == 'submitted')
                                        Sudah Isi
                                    @elseif($pdsa->status_pdsa == 'approved')
                                        Disetujui
                                    @endif
                                </span>

                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- DETAIL PDSA --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Form PDSA</h4>
                    </div>

                    <div class="card-body">

                        @foreach (['plan', 'do', 'study', 'action'] as $f)
                            <div class="row mb-3 align-items-start">
                                <label class="col-md-3 col-form-label fw-semibold text-uppercase">
                                    {{ $f }}
                                </label>
                                <div class="col-md-9">
                                    <textarea class="form-control" rows="4" readonly>{{ $pdsa->$f }}</textarea>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="{{ route('pdsa.index') }}" class="btn btn-light-secondary" title="Kembali">
                            <i class="bi bi-arrow-left"></i>
                        </a>

                        <a href="{{ route('pdsa.edit', $pdsa->id) }}" class="btn btn-warning" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>

                        @if ($pdsa->status_pdsa === 'submitted')
                            <form action="{{ route('pdsa.approve', $pdsa->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary" title="Approve">
                                    <i class="bi bi-check-circle"></i> Approve
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection