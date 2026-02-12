@php
    $user = auth()->user();
@endphp

@extends('layouts.app')

@section('title', 'Edit PDSA')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>EDIT PDSA</h3>
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
<section id="pdsa-edit">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card shadow-sm">

                <div class="card-header">
                    <h4 class="card-title mb-0">Form PDSA</h4>
                </div>

                {{-- Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger m-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pdsa.update', $pdsa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        {{-- PLAN DO STUDY ACTION --}}
                        @foreach ([
                            'plan' => 'Plan (Perencanaan)',
                            'do' => 'Do (Pelaksanaan)',
                            'study' => 'Study (Evaluasi)',
                            'action' => 'Action (Tindak Lanjut)'
                        ] as $field => $label)

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    {{ $label }}
                                </label>

                                <textarea 
                                    name="{{ $field }}" 
                                    rows="4" 
                                    class="form-control"
                                    required>{{ old($field, $pdsa->$field) }}</textarea>
                            </div>

                        @endforeach


                        {{-- CATATAN REVISI --}}
                        @if($pdsa->catatan_mutu)
                            <div class="card border-warning bg-light-warning mt-4">
                                <div class="card-body">
                                    <h6 class="fw-bold text-warning mb-2">
                                        <i class="bi bi-exclamation-circle"></i> 
                                        Catatan Revisi
                                    </h6>
                                    <p class="mb-0">
                                        {{ $pdsa->catatan_mutu }}
                                    </p>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer d-flex justify-content-end gap-2">

                        @if(in_array(Auth::user()->unit_id, [1, 2]))
                            <a href="{{ route('pdsa.index') }}" class="btn btn-light-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-light-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</section>
@endsection
