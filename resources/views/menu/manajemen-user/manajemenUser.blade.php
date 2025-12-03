@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Default Layout')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen User</h3>
                    <p class="text-subtitle text-muted">
                        Halaman untuk mengelola user dalam sistem.
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
                                    Manajemen User
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
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah User Baru</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-vertical">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Nama Lengkap</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control"
                                                        placeholder="Masukkan nama lengkap" id="first-name-icon" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Username</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control"
                                                        placeholder="Masukkan username" id="first-name-icon" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="email-id-icon">Email</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control"
                                                        placeholder="Masukkan alamat email" id="email-id-icon" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="password-id-icon">Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control"
                                                        placeholder="Masukkan password" id="password-id-icon" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="mobile-id-icon">Role</label>
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="basicSelect">
                                                            <option>IT</option>
                                                            <option>B</option>
                                                            <option>C</option>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <div class="checkbox mt-2">
                                                    <input type="checkbox" id="remember-me-v" class="form-check-input" />
                                                    <label for="remember-me-v">User Aktif</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                                Simpan
                                            </button>
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Daftar User</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>Nama & Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <span class="btn btn-primary">+ Input Data</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- >>> END OF KOREKSI <<< --}}

        </div>
    </section>
@endsection
