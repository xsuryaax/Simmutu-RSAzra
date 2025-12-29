<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\KamusIndikatorMutuController;
use App\Http\Controllers\LaporanAnalisisController;
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
use App\Http\Controllers\PDSAController;
use App\Http\Controllers\IMNController;
use App\Http\Controllers\MIMNController;
use App\Http\Controllers\IMPRSController;
use App\Http\Controllers\MIMPRSController;
use App\Http\Controllers\KamusIMPRSController;
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

Route::get('/unauthorized', function () {
    return view('errors.unauthorized');
})->name('unauthorized');


/*
|--------------------------------------------------------------------------
| ROUTE WAJIB LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');;

    Route::get('/chart', function () {
        return view('admin.chart');
    });

    // Menu Manajemen Mutu
    Route::resource('master-indikator-unit', MasterIndikatorController::class)
        ->middleware('check.role:master_indikator_unit');
    Route::resource('cakupan-data', CakupanDataController::class)
        ->middleware('check.role:cakupan_data');
    Route::resource('dimensi-mutu', DimensiMutuController::class)
        ->middleware('check.role:dimensi_mutu');
    Route::resource('frekuensi-analisis-data', FrekuensiAnalisisDataController::class)
        ->middleware('check.role:frekuensi_analisis_data');
    Route::resource('frekuensi-pengumpulan-data', FrekuensiPengumpulanDataController::class)
        ->middleware('check.role:frekuensi_pengumpulan_data');
    Route::resource('interpretasi-data', InterpretasiDataController::class)
        ->middleware('check.role:interpretasi_data');
    Route::resource('metodologi-pengumpulan-data', MetodologiPengumpulanDataController::class)
        ->middleware('check.role:metodologi_pengumpulan_data');
    Route::resource('metodologi-analisis-data', MetodologiAnalisisDataController::class)
        ->middleware('check.role:metodologi_analisis_data');
    Route::resource('publikasi-data', PublikasiDataController::class)
        ->middleware('check.role:publikasi_data');

    // Indikator Mutu Nasional
    Route::get('indikator-mutu-nasional', [IMNController::class, 'index'])->name('indikator-mutu-nasional.index');
    Route::get('indikator-mutu-nasional/create', [IMNController::class, 'create'])->name('indikator-mutu-nasional.create');
    Route::get('indikator-mutu-nasional/edit', [IMNController::class, 'edit'])->name('indikator-mutu-nasional.edit');

    // master Indikator Mutu Nasional
    Route::get('master-indikator-mutu-nasional', [MIMNController::class, 'index'])->name('master-indikator-mutu-nasional.index');
    Route::get('master-indikator-mutu-nasional/create', [MIMNController::class, 'create'])->name('master-indikator-mutu-nasional.create');
    Route::get('master-indikator-mutu-nasional/edit', [MIMNController::class, 'edit'])->name('master-indikator-mutu-nasional.edit');

    // Indikator Mutu Prioritas RS
    Route::get('indikator-mutu-prioritas-rs', [IMPRSController::class, 'index'])->name('indikator-mutu-prioritas-rs.index');
    Route::get('indikator-mutu-prioritas-rs/create', [IMPRSController::class, 'create'])->name('indikator-mutu-prioritas-rs.create');
    Route::get('indikator-mutu-prioritas-rs/edit', [IMPRSController::class, 'edit'])->name('indikator-mutu-prioritas-rs.edit');

    // master Indikator Mutu Prioritas RS
    Route::get('master-indikator-mutu-prioritas-rs', [MIMPRSController::class, 'index'])->name('master-indikator-mutu-prioritas-rs.index');
    Route::get('master-indikator-mutu-prioritas-rs/create', [MIMPRSController::class, 'create'])->name('master-indikator-mutu-prioritas-rs.create');
    Route::get('master-indikator-mutu-prioritas-rs/edit', [MIMPRSController::class, 'edit'])->name('master-indikator-mutu-prioritas-rs.edit');

    // kamus Indikator Mutu Prioritas RS
    Route::get('kamus-indikator-mutu-prioritas-rs', [KamusIMPRSController::class, 'index'])->name('kamus-indikator-mutu-prioritas-rs.index');
    Route::get('kamus-indikator-mutu-prioritas-rs/create', [KamusIMPRSController::class, 'create'])->name('kamus-indikator-mutu-prioritas-rs.create');
    Route::get('kamus-indikator-mutu-prioritas-rs/edit', [KamusIMPRSController::class, 'edit'])->name('kamus-indikator-mutu-prioritas-rs.edit');

    // Manajemen Role, User, Unit
    Route::resource('manajemen-role', ManajemenRoleController::class)
        ->middleware('check.role:manage_role');
    Route::resource('manajemen-user', ManajemenUserController::class)
        ->middleware('check.role:manajemen_user');
    Route::resource('manajemen-unit', ManajemenUnitController::class)
        ->middleware('check.role:manajemen_unit');

    // Kamus & Laporan
    Route::resource('kamus-indikator-mutu-unit', KamusIndikatorMutuController::class)
        ->middleware('check.role:kamus_indikator_mutu_unit');
    Route::resource('laporan-analisis', LaporanAnalisisController::class)
        ->middleware('check.role:laporan_analisis');

    // Hak akses
    Route::get('hak-akses', [HakAksesController::class, 'index'])
        ->name('hak-akses.index')
        ->middleware('check.role:hak_akses');
    Route::put('hak-akses/update/{role}', [HakAksesController::class, 'update'])
        ->name('hak-akses.update')
        ->middleware('check.role:hak_akses');

    // PDSA
    Route::resource('pdsa', PDSAController::class)
        ->middleware('check.role:pdsa');

    Route::resource('dashboard', DashboardController::class)
        ->middleware('check.role:dashboard');
});
