@extends('layouts.app')

@section('title', 'Manajemen Hak Akses')

@section('page-title')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Manajemen Hak Akses</h3>
                    <p class="text-subtitle text-muted">
                        Data hak akses per role di rumah sakit Azra
                    </p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <div class="justify-content-end d-flex">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="btn btn-primary">
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
                                    Manajemen Hak Akses
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
@endsection


    @section('content')
    <div class="card">
        <div class="card-body">
            {{-- PILIH ROLE --}}
            <form method="GET" action="">
                <div class="mb-3">
                    <label>Pilih Role</label>
                    <select name="role_id" class="form-control" onchange="this.form.submit()">
                        @foreach($roles as $r)
                        <option value="{{ $r->id }}" {{ $selectedRole == $r->id ? 'selected' : '' }}>
                            {{ $r->nama_role }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>
            
            <form method="POST" action="{{ route('hak-akses.update', $selectedRole) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="role_id" value="{{ $selectedRole }}">
                @foreach($menuStructure as $groupKey => $group)
                <h5 class="mt-4">{{ $group['title'] }}</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Nama Menu</th>
                            <th style="width:100px">Akses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group['menus'] as $menu)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $menu['label'] }}</td>
                                <td>
                                    <input 
                                        type="checkbox" 
                                        name="menu_key[]" 
                                        value="{{ $menu['key'] }}"
                                        {{ in_array($menu['key'], $hakAkses) ? 'checked' : '' }}
                                    >
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endforeach
                <button class="btn btn-primary mt-3">Simpan Perubahan</button>
            </form>
        </div>
    </div>
    @endsection