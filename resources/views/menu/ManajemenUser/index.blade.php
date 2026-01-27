@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Manajemen User')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('page-title')
    <div class="page-header">
        <div class="page-header-left">
            <h3>Manajemen User</h3>
            <p class="text-subtitle text-muted">
                Halaman untuk mengelola user dalam sistem.
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
                            Manajemen User
                        </li>
                    </ol>
                </nav>
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
                            <form action="{{ route('manajemen-user.store') }}" method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="nama_lengkap">Nama Lengkap</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="nama_lengkap"
                                                        placeholder="Masukkan nama lengkap" id="nama_lengkap" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="username">Username</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="username"
                                                        placeholder="Masukkan username" id="username" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="email">Email</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="email"
                                                        placeholder="Masukkan alamat email" id="email" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="password">Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Masukkan password" id="password" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="role_id" name="role_id">
                                                            @foreach ($roles as $r)
                                                                <option value="{{ $r->id }}">{{ $r->nama_role }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="unit">Unit</label>
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="unit_id" name="unit_id">
                                                            @foreach ($units as $u)
                                                                <option value="{{ $u->id }}">{{ $u->nama_unit }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <div class="checkbox mt-2">
                                                    <input type="checkbox" id="status_user" name="status_user"
                                                        value="aktif" class="form-check-input" />
                                                    <label for="status_user">User Aktif</label>
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
                        <div class="table-responsive-md table-dark">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $u)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>
                                                <strong>{{ $u->nama_lengkap }}</strong><br>
                                                <small class="text-muted">{{ $u->username }}</small>
                                            </td>

                                            <td>{{ $u->email }}</td>
                                            <td>{{ $u->nama_role }}</td>
                                            <td>{{ $u->nama_unit ?? '-' }}</td>

                                            <td>
                                                @if ($u->status_user == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Non-Aktif</span>
                                                @endif
                                            </td>

                                            <td>
                                                <button class="btn btn-warning btn-sm"
                                                    onclick='openEditModal(@json($u))'>
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <form action="{{ route('manajemen-user.destroy', $u->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Hapus user ini?')">
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
    {{-- ====================== MODAL EDIT USER ======================= --}}
    <div class="modal fade" id="modalEditUser" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="formEditUser" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" id="eNama" name="nama_lengkap" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" id="eUsername" name="username" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" id="eEmail" name="email" class="form-control" required>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Password (Opsional)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role_id" id="eRole" class="form-control">
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->id }}">{{ $r->nama_role }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Unit</label>
                                    <select name="unit_id" id="eUnit" class="form-control">
                                        <option value="">Tidak Ada</option>
                                        @foreach ($units as $u)
                                            <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status User</label>
                                    <select name="status_user" id="eStatus" class="form-control">
                                        <option value="aktif">Aktif</option>
                                        <option value="non-aktif">Non-Aktif</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update User
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // ============== OPEN EDIT MODAL DAN ISI DATA ==============
        function openEditModal(user) {

            document.getElementById('eNama').value = user.nama_lengkap;
            document.getElementById('eUsername').value = user.username;
            document.getElementById('eEmail').value = user.email;
            document.getElementById('eRole').value = user.role_id;
            document.getElementById('eUnit').value = user.unit_id ?? "";
            document.getElementById('eStatus').value = user.status_user;

            // Set action form
            document.getElementById('formEditUser').action = "/manajemen-user/" + user.id;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('modalEditUser')).show();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
