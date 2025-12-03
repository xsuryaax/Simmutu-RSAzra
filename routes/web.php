<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('menu/dashboard/dashboard');
});
Route::get('laporanAnalisis', function () {
    return view('menu/laporan-analisis/laporanAnalisis');
});
Route::get('kamusIndikator', function () {
    return view('menu/kamus-indikator-mutu/kamusIndikator');
});
Route::get('manajemenUser', function () {
    return view('menu/manajemen-user/manajemenUser');
});
Route::get('manajemenRole', function () {
    return view('menu/manajemen-role/manajemenRole');
});
Route::get('manajemenUnit', function () {
    return view('menu/manajemen-unit/manajemenUnit');
});
Route::get('hakAkses', function () {
    return view('menu/hak-akses/hakAkses');
});

// manajemen data mutu
// master-indikator
Route::get('/master-indikator', function () {
    return view('menu/manajemen-data-mutu/master-indikator/index');
});
Route::get('/master-indikator/create', function () {
    return view('menu/manajemen-data-mutu/master-indikator/create');
});
Route::get('/master-indikator/edit', function () {
    return view('menu/manajemen-data-mutu/master-indikator/edit');
});

// cakupan-data
Route::get('/cakupan-data', function () {
    return view('menu/manajemen-data-mutu/cakupan-data/index');
});
Route::get('/cakupan-data/create', function () {
    return view('menu/manajemen-data-mutu/cakupan-data/create');
});
Route::get('/cakupan-data/edit', function () {
    return view('menu/manajemen-data-mutu/cakupan-data/edit');
});

// dimensi mutu
Route::get('dimensi-mutu', function () {
    return view('menu/manajemen-data-mutu/dimensi-mutu/index');
});
Route::get('dimensi-mutu/create', function () {
    return view('menu/manajemen-data-mutu/dimensi-mutu/create');
});
Route::get('dimensi-mutu/edit', function () {
    return view('menu/manajemen-data-mutu/dimensi-mutu/edit');
});

// frekuensi-analisis-data
Route::get('frekuensi-analisa-data', function () {
    return view('menu/manajemen-data-mutu/frekuensi-analisis-data/index');
});
Route::get('frekuensi-analisa-data/create', function () {
    return view('menu/manajemen-data-mutu/frekuensi-analisis-data/create');
});
Route::get('frekuensi-analisa-data/edit', function () {
    return view('menu/manajemen-data-mutu/frekuensi-analisis-data/edit');
});

// frekuensi pengumpulan data
Route::get('frekuensi-pengumpulan-data', function () {
    return view('menu/manajemen-data-mutu/frekuensi-pengumpulan-data/index');
});
Route::get('frekuensi-pengumpulan-data/create', function () {
    return view('menu/manajemen-data-mutu/frekuensi-pengumpulan-data/create');
});
Route::get('frekuensi-pengumpulan-data/edit', function () {
    return view('menu/manajemen-data-mutu/frekuensi-pengumpulan-data/edit');
});

// interpretasi data
Route::get('interpretasi-data', function () {
    return view('menu/manajemen-data-mutu/interpretasi-data/index');
});
Route::get('interpretasi-data/create', function () {
    return view('menu/manajemen-data-mutu/interpretasi-data/create');
});
Route::get('interpretasi-data/edit', function () {
    return view('menu/manajemen-data-mutu/interpretasi-data/edit');
});

// metodologi analisa data
Route::get('metodologi-analisa-data', function () {
    return view('menu/manajemen-data-mutu/metodologi-analisa-data/index');
});
Route::get('metodologi-analisa-data/create', function () {
    return view('menu/manajemen-data-mutu/metodologi-analisa-data/create');
});
Route::get('metodologi-analisa-data/edit', function () {
    return view('menu/manajemen-data-mutu/metodologi-analisa-data/edit');
});

// metodologi pengumpulan data
Route::get('metodologi-pengumpulan-data', function () {
    return view('menu/manajemen-data-mutu/metodologi-pengumpulan-data/index');
});
Route::get('metodologi-pengumpulan-data/create', function () {
    return view('menu/manajemen-data-mutu/metodologi-pengumpulan-data/create');
});
Route::get('metodologi-pengumpulan-data/edit', function () {
    return view('menu/manajemen-data-mutu/metodologi-pengumpulan-data/edit');
});

// publikasi data
Route::get('publikasi-data', function () {
    return view('menu/manajemen-data-mutu/publikasi-data/index');
});
Route::get('publikasi-data/create', function () {
    return view('menu/manajemen-data-mutu/publikasi-data/create');
});
Route::get('publikasi-data/edit', function () {
    return view('menu/manajemen-data-mutu/publikasi-data/edit');
});

// login
Route::get('login', function () {
    return view('auth/login');
});
