@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Manajemen Role</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola role dalam sistem.
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
                            Manajemen Role
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    {{-- ==================== CARD STATISTIK ===================== --}}
    <div class="row">
        <div class="col-6 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 justify-content-start">
                            <h6 class="text-muted font-semibold">
                                Total Role
                            </h6>
                            <h6 class="font-extrabold mb-0">{{ $total_role }}</h6>
                        </div>
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 justify-content-end">
                            <div class="stats-icon purple mb-2">
                                <i class="bi bi-shield-lock-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 justify-content-start">
                            <h6 class="text-muted font-semibold">Role Aktif</h6>
                            <h6 class="font-extrabold mb-0">{{ $role_aktif }}</h6>
                        </div>
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 justify-content-end">
                            <div class="stats-icon green mb-2">
                                <i class="bi bi-shield-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 justify-content-start">
                            <h6 class="text-muted font-semibold">Role Tidak Aktif</h6>
                            <h6 class="font-extrabold mb-0">{{ $role_nonaktif }}</h6>
                        </div>
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 justify-content-end">
                            <div class="stats-icon red mb-2">
                                <i class="bi bi-shield-x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <section class="section">
        <div class="row">

            {{-- ================= CARD TAMBAH ROLE ================= --}}
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Tambah Role</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('manajemen-role.store') }}" method="POST">
                            @csrf

                            <div class="form-group has-icon-left mb-3">
                                <label>Nama Role</label>
                                <div class="position-relative">
                                    <input type="text" name="nama_role" class="form-control" placeholder="Contoh: Admin"
                                        value="{{ old('nama_role') }}" required>

                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock-fill"></i>
                                    </div>

                                    @error('nama_role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group has-icon-left mb-3">
                                <label>Deskripsi</label>
                                <div class="position-relative">
                                    <textarea name="deskripsi_role" class="form-control" rows="3" placeholder="Deskripsi role">{{ old('deskripsi_role') }}</textarea>

                                    <div class="form-control-icon">
                                        <i class="bi bi-card-text"></i>
                                    </div>

                                    @error('deskripsi_role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <button class="btn btn-primary w-100">
                                <i class="bi bi-floppy"></i> Simpan Role
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ================= TABLE ================= --}}
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Data Role</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive-md table-dark">
                            <table class="table table-striped table-hover" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Role</th>
                                        <th>Deskripsi</th>
                                        <th>Total User</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->nama_role }}</td>
                                            <td>{{ $role->deskripsi_role }}</td>
                                            <td>
                                                @if ($role->total_user > 0)
                                                    <span class="badge bg-success">{{ $role->total_user }}</span>
                                                @else
                                                    <span class="badge bg-secondary">0</span>
                                                @endif
                                            </td>

                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm"
                                                    onclick='openEditModal(@json($role))'>
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <form action="{{ route('manajemen-role.destroy', $role->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
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
            </div>

        </div>
    </section>

    {{-- ===================== MODAL EDIT ROLE ===================== --}}
    <div class="modal fade" id="modalEditRole" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" id="formEditRole">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="form-group has-icon-left mb-3">
                            <label>Nama Role</label>
                            <div class="position-relative">
                                <input type="text" id="editNamaRole" name="nama_role" class="form-control" required>
                                <div class="form-control-icon">
                                    <i class="bi bi-shield"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group has-icon-left mb-3">
                            <label>Deskripsi</label>
                            <div class="position-relative">
                                <textarea id="editDeskripsiRole" name="deskripsi_role" class="form-control" rows="3"></textarea>
                                <div class="form-control-icon">
                                    <i class="bi bi-card-text"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // DataTable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

        // Open modal
        function openEditModal(role) {
            document.getElementById('editNamaRole').value = role.nama_role;
            document.getElementById('editDeskripsiRole').value = role.deskripsi_role ?? '';
            document.getElementById('formEditRole').action = "/manajemen-role/" + role.id;

            let modal = new bootstrap.Modal(document.getElementById('modalEditRole'));
            modal.show();
        }
    </script>
@endpush
