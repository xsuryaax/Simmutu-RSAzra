@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
        <div class="text-center">
            <h1 class="display-1 text-danger">403</h1>
            <h3>Hak Akses Ditolak</h3>
            <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Kembali ke Dashboard</a>
        </div>
    </div>
@endsection