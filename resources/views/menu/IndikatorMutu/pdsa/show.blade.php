@extends('layouts.app')

@section('title', 'Detail PDSA')

@section('page-title')
<div class="page-header">
    <div class="page-header-left">
        <h3>Detail PDSA</h3>
        <p class="text-subtitle text-muted">
            Detail dan pengisian Plan Do Study Action
        </p>
    </div>

    <div class="page-header-right">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/pdsa') }}">PDSA</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('content')
@php
    $user = Auth::user();

    $isMutu = in_array($user->unit_id, [1, 2]);
    $isUnit = !in_array($user->unit_id, [1, 2]);

    $isEditMode = request()->get('edit') == 1;

    // DEFAULT readonly
    $readonly = true;

    // Unit bisa edit selama belum approved
    if ($isUnit && $pdsa->status_pdsa !== 'approved') {
        $readonly = false;
    }

    // Mutu/Admin bisa edit jika klik tombol edit
    if ($isMutu && $isEditMode) {
        $readonly = false;
    }
@endphp

<section id="pdsa-detail">
<div class="row match-height">

    {{-- ================= INFO ================= --}}
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                <h4 class="card-title">Informasi PDSA</h4>
            </div>
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Indikator</div>
                    <div class="col-md-8">: {{ $pdsa->indikator_id }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Unit</div>
                    <div class="col-md-8">: {{ $pdsa->unit_id }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Periode</div>
                    <div class="col-md-8">: {{ $pdsa->quarter }} {{ $pdsa->tahun }}</div>
                </div>

                <div class="row">
                    <div class="col-md-4 fw-semibold">Status</div>
                    <div class="col-md-8">
                        <span class="badge
                            {{ $pdsa->status_pdsa == 'assigned' ? 'bg-warning' : '' }}
                            {{ $pdsa->status_pdsa == 'submitted' ? 'bg-info' : '' }}
                            {{ $pdsa->status_pdsa == 'approved' ? 'bg-success' : '' }}">
                            {{ strtoupper($pdsa->status_pdsa) }}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= FORM ================= --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Form PDSA</h4>
            </div>

            <div class="card-body">
                <form method="POST">
                    @csrf

                    {{-- PLAN --}}
                    <div class="row mb-4">
                        <div class="col-md-4 fw-semibold">PLAN</div>
                        <div class="col-md-8">
                            <textarea name="plan" rows="4" class="form-control"
                                {{ $readonly ? 'readonly' : '' }}>{{ old('plan', $pdsa->plan) }}</textarea>
                        </div>
                    </div>

                    {{-- DO --}}
                    <div class="row mb-4">
                        <div class="col-md-4 fw-semibold">DO</div>
                        <div class="col-md-8">
                            <textarea name="do" rows="4" class="form-control"
                                {{ $readonly ? 'readonly' : '' }}>{{ old('do', $pdsa->do) }}</textarea>
                        </div>
                    </div>

                    {{-- STUDY --}}
                    <div class="row mb-4">
                        <div class="col-md-4 fw-semibold">STUDY</div>
                        <div class="col-md-8">
                            <textarea name="study" rows="4" class="form-control"
                                {{ $readonly ? 'readonly' : '' }}>{{ old('study', $pdsa->study) }}</textarea>
                        </div>
                    </div>

                    {{-- ACTION --}}
                    <div class="row mb-4">
                        <div class="col-md-4 fw-semibold">ACTION</div>
                        <div class="col-md-8">
                            <textarea name="action" rows="4" class="form-control"
                                {{ $readonly ? 'readonly' : '' }}>{{ old('action', $pdsa->action) }}</textarea>
                        </div>
                    </div>

                    {{-- ================= BUTTON ================= --}}
                    <div class="d-flex justify-content-end gap-2">

                        {{-- KEMBALI --}}
                        <a href="{{ url('/pdsa') }}" class="btn btn-light-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>

                        {{-- UNIT - Submit --}}
                        @if ($isUnit && $pdsa->status_pdsa === 'assigned')
                            <button formaction="{{ route('pdsa.submit', $pdsa->id) }}" class="btn btn-success">
                                <i class="bi bi-send"></i> Submit
                            </button>
                        @endif

                        {{-- EDIT & SIMPAN --}}
                        @if (($isUnit && $pdsa->status_pdsa !== 'approved') || $isMutu)
                            @if (!$isEditMode)
                                <a href="{{ route('pdsa.show', $pdsa->id) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            @endif

                            @if ($isEditMode)
                                <button formaction="{{ route('pdsa.update', $pdsa->id) }}" class="btn btn-warning">
                                    <i class="bi bi-save"></i> Simpan
                                </button>
                            @endif
                        @endif

                        {{-- MUTU - Approve --}}
                        @if ($isMutu && $pdsa->status_pdsa === 'submitted')
                            <button formaction="{{ url('/pdsa/'.$pdsa->id.'/approve') }}" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Approve
                            </button>
                        @endif

                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
</section>
@endsection
