@extends('layouts.app')

{{-- Bagian Title Halaman --}}
@section('title', 'Manajemen User')

{{-- Bagian Breadcrumb dan Halaman Title --}}
@section('subtitle', 'Halaman untuk mengelola user dalam sistem.')

{{-- Bagian Konten Utama --}}
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted font-bold small mb-1">Total User</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalUser }}</h6>
                            </div>
                            <div class="stats-icon blue" style="width: 3rem; height: 3rem;">
                                <i class="bi bi-people-fill" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted font-bold small mb-1">Total User Aktif</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalAktif }}</h6>
                            </div>
                            <div class="stats-icon green" style="width: 3rem; height: 3rem;">
                                <i class="bi bi-person-check-fill" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted font-bold small mb-1">Total User Tidak Aktif</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalNonaktif }}</h6>
                            </div>
                            <div class="stats-icon red" style="width: 3rem; height: 3rem;">
                                <i class="bi bi-person-x-fill" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah User Baru</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body py-1 px-4">
                            <form action="{{ route('manajemen-user.store') }}" method="POST">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="nama_lengkap" class="small fw-bold">Nama Lengkap <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="nama_lengkap"
                                                        placeholder="Masukkan nama lengkap" id="nama_lengkap" required />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="nip" class="small fw-bold">NIP <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="nip"
                                                        placeholder="Masukkan NIP" id="nip" required />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-card-heading"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="username" class="small fw-bold">Username <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="username"
                                                        placeholder="Masukkan username" id="username" required />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="email" class="small fw-bold">Email <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="email"
                                                        placeholder="Masukkan alamat email" id="email" required />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="password" class="small fw-bold">Password <span class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" name="password"
                                                        placeholder="Masukkan password" id="password" required />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="password_confirmation" class="small fw-bold">Konfirmasi Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" name="password_confirmation"
                                                        placeholder="Ulangi password" id="password_confirmation" required />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-lock-fill"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="unit" class="small fw-bold">Unit / Organisasi <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="unit_id" name="unit_id" required>
                                                            <option value="" disabled selected>Pilih Unit / Organisasi</option>
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
                                            <div class="form-group">
                                                <label for="role" class="small fw-bold">Role / Jabatan <span
                                                        class="text-danger">*</span></label>
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="role_id" name="role_id" required>
                                                            <option value="" disabled selected>Pilih Role / Jabatan</option>
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
                                                <label for="profesi" class="small fw-bold">Profesi</label>
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="profesi" name="profesi">
                                                            <option value="" disabled selected>Pilih Profesi</option>
                                                            <option value="Medis">Medis</option>
                                                            <option value="Non Medis">Non Medis</option>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="atasan_langsung" class="small fw-bold">Atasan Langsung</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" name="atasan_langsung"
                                                        placeholder="Masukkan Nama Atasan" id="atasan_langsung" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-person-check"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <div class="checkbox mt-2">
                                                    <input type="checkbox" id="status_user" name="status_user"
                                                        value="aktif" class="form-check-input" />
                                                    <label for="status_user" class="small fw-bold">User Aktif</label>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <form action="" method="GET" class="d-flex align-items-center">
                                <select name="unit_id" class="form-select" onchange="this.form.submit()"
                                    style="min-width: 200px;">
                                    <option value="">Semua Unit</option>
                                    @foreach ($units as $u)
                                        <option value="{{ $u->id }}"
                                            {{ ($selectedUnit ?? '') == $u->id ? 'selected' : '' }}>
                                            {{ $u->nama_unit }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div id="table-search-header"></div>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped table-sm" id="table1">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>DATA KARYAWAN</th>
                                        <th>USERNAME / EMAIL</th>
                                        <th>AKSES</th>
                                        <th class="text-center">STATUS</th>
                                        <th class="text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $u)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>
                                                @if($u->nama_lengkap)
                                                    <strong class="text-dark">{{ $u->nama_lengkap }}</strong><br>
                                                @endif
                                                <small class="text-muted">NIP: {{ $u->nip ?? '-' }} | {{ $u->profesi ?? '-' }}</small>
                                            </td>

                                            <td>
                                                <strong class="text-dark">{{ $u->username }}</strong><br>
                                                <small class="text-muted">{{ $u->email }}</small>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-start">
                                                    <div>
                                                        <strong class="text-dark">{{ $u->nama_role }}</strong><br>
                                                        <small class="text-muted">{{ $u->nama_unit ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center align-middle">
                                                @if ($u->status_user == 'aktif')
                                                    <span class="badge bg-success text-white px-2 py-1 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">AKTIF</span>
                                                @else
                                                    <span class="badge bg-secondary text-white px-2 py-1 text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">NON-AKTIF</span>
                                                @endif
                                            </td>

                                            <td class="text-center align-middle">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-warning btn-sm" onclick='openEditModal(@json($u))'>
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('manajemen-user.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

                                <div class="mb-3">
                                    <label class="form-label">NIP (Opsional)</label>
                                    <input type="text" id="eNip" name="nip" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Profesi (Opsional)</label>
                                    <select name="profesi" id="eProfesi" class="form-control">
                                        <option value="">Pilih Profesi</option>
                                        <option value="Medis">Medis</option>
                                        <option value="Non Medis">Non Medis</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label class="form-label">Password (Opsional)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select name="role_id" id="eRole" class="form-control" required>
                                        <option value="" disabled selected>Pilih Role</option>
                                        @foreach ($roles as $r)
                                            <option value="{{ $r->id }}">{{ $r->nama_role }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Unit</label>
                                    <select name="unit_id" id="eUnit" class="form-control" required>
                                        <option value="" disabled selected>Pilih Unit</option>
                                        <option value="">Tidak Ada</option>
                                        @foreach ($units as $u)
                                            <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Atasan Langsung (Opsional)</label>
                                    <input type="text" id="eAtasan" name="atasan_langsung" class="form-control">
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
            document.getElementById('eNip').value = user.nip ?? "";
            document.getElementById('eProfesi').value = user.profesi ?? "";
            document.getElementById('eAtasan').value = user.atasan_langsung ?? "";
            document.getElementById('eStatus').value = user.status_user;

            // Set action form
            document.getElementById('formEditUser').action = "/manajemen-user/" + user.id;

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('modalEditUser')).show();
        }

        // Move search bar to header
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                const searchContainer = document.querySelector('.dt-search-container');
                const headerPlaceholder = document.getElementById('table-search-header');
                if (searchContainer && headerPlaceholder) {
                    headerPlaceholder.appendChild(searchContainer);
                }
                // Hide the empty control bar if it remains
                const emptyControl = document.querySelector('.table-custom-controls');
                if (emptyControl && !emptyControl.innerText.trim()) {
                    emptyControl.style.display = 'none';
                }
            }, 300);
        });
    </script>

@endpush
