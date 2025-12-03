@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Metodologi Pengumpulan Data</h3>
                    <p class="text-subtitle text-muted">
                        Halaman untuk mengelola Metodologi Pengumpulan Data mutu RS Azra.
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
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
                                    Metodologi Pengumpulan Data
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Bagian Konten Utama --}}
@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title">Metodologi Pengumpulan Data</h5>
                <a href="metodologi-pengumpulan-data/create" class="btn btn-primary float-end">
                    <i class="bi bi-plus-circle"></i> Tambah Metodologi Pengumpulan Data
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="table1">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="{{ url('/metodologi-pengumpulan-data/edit') }}" class="btn btn-edit"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <span class="btn btn-danger"><i class="bi bi-trash3-fill"></i></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
