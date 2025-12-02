<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('menu/dashboard');
});
Route::get('laporanAnalisis', function () {
    return view('menu/laporanAnalisis');
});
Route::get('kamusIndikator', function () {
    return view('menu/kamusIndikator');
});
Route::get('manajemenUser', function () {
    return view('menu/manajemenUser');
});
Route::get('manajemenRole', function () {
    return view('menu/manajemenRole');
});
Route::get('manajemenUnit', function () {
    return view('menu/manajemenUnit');
});
Route::get('hakAkses', function () {
    return view('menu/hakAkses');
});
