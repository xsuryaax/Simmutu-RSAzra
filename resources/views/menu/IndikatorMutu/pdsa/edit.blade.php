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
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Form PDSA</h4>
                    </div>

                    <form action="{{ route('pdsa.update', $pdsa->id) }}" method="POST" class="form form-horizontal">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">

                                @foreach (['plan', 'do', 'study', 'action'] as $field)
                                    <div class="col-md-4">
                                        <label class="text-uppercase">{{ $field }}</label>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <textarea name="{{ $field }}" rows="4" class="form-control"
                                            required>{{ old($field, $pdsa->$field) }}</textarea>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end gap-2">
                            @if(in_array(Auth::user()->unit_id, [1, 2]))
                                <a href="{{ route('pdsa.index') }}" class="btn btn-light-secondary">
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="btn btn-light-secondary">
                                    <i class="bi bi-arrow-left"></i>
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