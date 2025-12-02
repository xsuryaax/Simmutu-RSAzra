<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KamusIndikatorMutuController;
use App\Http\Controllers\ManajemenMutu\CakupanDataController;
use App\Http\Controllers\ManajemenMutu\DimensiMutuController;
use App\Http\Controllers\ManajemenMutu\FrekuensiAnalisisDataController;
use App\Http\Controllers\ManajemenMutu\FrekuensiPengumpulanDataController;
use App\Http\Controllers\ManajemenMutu\InterpretasiDataController;
use App\Http\Controllers\ManajemenMutu\MasterIndikatorController;
use App\Http\Controllers\ManajemenMutu\MetodologiAnalisisDataController;
use App\Http\Controllers\ManajemenMutu\MetodologiPengumpulanDataController;
use App\Http\Controllers\ManajemenMutu\PublikasiDataController;
use App\Http\Controllers\ManajemenRoleController;
use App\Http\Controllers\ManajemenUnitController;
use App\Http\Controllers\ManajemenUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH (bebas diakses)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTE WAJIB LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::resource('master-indikator', MasterIndikatorController::class);
    Route::resource('manajemen-unit', ManajemenUnitController::class);
    Route::resource('cakupan-data', CakupanDataController::class);
    Route::resource('dimensi-mutu', DimensiMutuController::class);
    Route::resource('frekuensi-analisis-data', FrekuensiAnalisisDataController::class);
    Route::resource('frekuensi-pengumpulan-data', FrekuensiPengumpulanDataController::class);
    Route::resource('interpretasi-data', InterpretasiDataController::class);
    Route::resource('metodologi-pengumpulan-data', MetodologiPengumpulanDataController::class);
    Route::resource('metodologi-analisis-data', MetodologiAnalisisDataController::class);
    Route::resource('publikasi-data', PublikasiDataController::class);
    Route::resource('manajemen-role', ManajemenRoleController::class);
    Route::resource('manajemen-user', ManajemenUserController::class);
    Route::resource('kamus-indikator-mutu', KamusIndikatorMutuController::class);
});
