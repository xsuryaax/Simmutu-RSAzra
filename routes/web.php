<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportPdfController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\IndikatorMutu\ValidatorDataController;
use App\Http\Controllers\IndikatorPeriodeController;
use App\Http\Controllers\ManajemenRoleController;
use App\Http\Controllers\ManajemenUnitController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\PDSAController;

use App\Http\Controllers\IndikatorMutu\KamusIndikatorController;
use App\Http\Controllers\IndikatorMutu\MasterIndikatorController;
use App\Http\Controllers\IndikatorMutu\LaporanAnalisController;
use App\Http\Controllers\IndikatorMutu\AnalisaController;

use App\Http\Controllers\ManajemenMutu\JenisIndikatorController;
use App\Http\Controllers\ManajemenMutu\MetodePengumpulanDataController;
use App\Http\Controllers\ManajemenMutu\DimensiMutuController;
use App\Http\Controllers\ManajemenMutu\KategoriIMPRSController;
use App\Http\Controllers\ManajemenMutu\PeriodeAnalisisDataController;
use App\Http\Controllers\ManajemenMutu\PeriodePengumpulanDataController;
use App\Http\Controllers\ManajemenMutu\PenyajianDataController;

use App\Http\Controllers\PeriodeController;
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

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    ;

    Route::get('/chart', function () {
        return view('admin.chart');
    });

    // Indikator Mutu Prioritas Unit
    Route::resource('master-indikator', MasterIndikatorController::class)
        ->middleware('check.role:master_indikator');
    Route::resource('kamus-indikator', KamusIndikatorController::class)
        ->middleware('check.role:kamus_indikator');
    Route::resource('kategori-imprs', KategoriIMPRSController::class)
        ->middleware('check.role:kategori_imprs');

    Route::resource('laporan-analis', LaporanAnalisController::class)
        ->middleware('check.role:laporan_analis');
    Route::get('/laporan-analis/kalender', [LaporanAnalisController::class, 'getKalenderIndikator'])
        ->name('laporan-analis.kalender');
    // Route untuk Laporan Analis
    Route::get('/laporan-analis/{id}/detail', [LaporanAnalisController::class, 'getDetail'])
        ->name('laporan-analis.detail');


    Route::get('/laporan-validator', [ValidatorDataController::class, 'index'])
        ->name('laporan-validator.index');

    Route::post('/laporan-validator', [ValidatorDataController::class, 'store'])
        ->name('laporan-validator.store');
    Route::put('/laporan-validator/{id}', [ValidatorDataController::class, 'update'])
        ->name('laporan-validator.update');

    Route::get('/laporan-validator/{id}/detail', [ValidatorDataController::class, 'detail'])
        ->name('laporan-validator.show');


    Route::get('analisa-data', [AnalisaController::class, 'index'])
        ->middleware('check.role:laporan_analis')
        ->name('analisa-data.index');

    // Menu Manajemen Mutu
    Route::resource('dimensi-mutu', DimensiMutuController::class)
        ->middleware('check.role:dimensi_mutu');
    Route::resource('periode-analisis-data', PeriodeAnalisisDataController::class)
        ->middleware('check.role:periode_analisis_data');
    Route::resource('periode-pengumpulan-data', PeriodePengumpulanDataController::class)
        ->middleware('check.role:periode_pengumpulan_data');
    Route::resource('metode-pengumpulan-data', MetodePengumpulanDataController::class)
        ->middleware('check.role:metode_pengumpulan_data');
    Route::resource('penyajian-data', PenyajianDataController::class)
        ->middleware('check.role:penyajian_data');
    Route::resource('jenis-indikator', JenisIndikatorController::class)
        ->middleware('check.role:jenis_indikator');

    // Manajemen Role, User, Unit
    Route::resource('manajemen-role', ManajemenRoleController::class)
        ->middleware('check.role:manage_role');
    Route::resource('manajemen-user', ManajemenUserController::class)
        ->middleware('check.role:manajemen_user');
    Route::resource('manajemen-unit', ManajemenUnitController::class)
        ->middleware('check.role:manajemen_unit');

    // Hak akses
    Route::get('hak-akses', [HakAksesController::class, 'index'])
        ->name('hak-akses.index')
        ->middleware('check.role:hak_akses');
    Route::put('hak-akses/update/{role}', [HakAksesController::class, 'update'])
        ->name('hak-akses.update')
        ->middleware('check.role:hak_akses');

    // PDSA (Plan-Do-Study-Act)
    Route::get('/pdsa', [PDSAController::class, 'index'])
        ->name('pdsa.index')
        ->middleware('check.role:pdsa');
    Route::post('/pdsa/assign', [PDSAController::class, 'assign'])->name('pdsa.assign');
    Route::get('/pdsa/{id}', [PDSAController::class, 'show'])
        ->name('pdsa.show')
        ->middleware('check.role:pdsa');
    Route::get('/pdsa/{id}/submit', [PDSAController::class, 'formSubmit'])->name('pdsa.submit.form');
    Route::post('/pdsa/{id}/submit', [PDSAController::class, 'submit'])->name('pdsa.submit');
    Route::get('/pdsa/{id}/edit', [PDSAController::class, 'edit'])->name('pdsa.edit');
    Route::put('/pdsa/{id}', [PDSAController::class, 'update'])->name('pdsa.update');
    Route::post('/pdsa/{id}/revisi', [PDSAController::class, 'revise'])
        ->name('pdsa.revise');
    Route::post('/pdsa/{id}/approve', [PDSAController::class, 'approve'])
        ->name('pdsa.approve')
        ->middleware('check.role:pdsa');

    Route::resource('dashboard', DashboardController::class)
        ->middleware('check.role:dashboard');

    Route::get('/periode-mutu', [PeriodeController::class, 'index'])
        ->name('periode-mutu.index')->middleware('check.role:periode_mutu');
    Route::get('/periode-mutu/create', [PeriodeController::class, 'create'])
        ->name('periode-mutu.create');
    Route::post('/periode-mutu', [PeriodeController::class, 'store'])
        ->name('periode-mutu.store');
    Route::patch('/periode-mutu/{id}/aktif', [PeriodeController::class, 'setAktif'])
        ->name('periode-mutu.aktif');
    Route::get('/periode-mutu/{id}/edit', [PeriodeController::class, 'edit'])->name('periode-mutu.edit');
    Route::patch('/periode-mutu/{id}', [PeriodeController::class, 'update'])->name('periode-mutu.update');
    Route::delete('/periode-mutu/{id}', [PeriodeController::class, 'destroy'])->name('periode-mutu.destroy');

    Route::post('/export/pdf/chart', [ExportPdfController::class, 'exportChart'])
        ->name('export.pdf.chart');

    Route::get('/laporan-analis/kalender', [LaporanAnalisController::class, 'getKalenderIndikator'])->name('laporan-analis.kalender');
    // Route untuk Laporan Analis
    Route::get('/laporan-analis/{id}/detail', [LaporanAnalisController::class, 'getDetail'])->name('laporan-analis.detail');
    Route::put('/laporan-analis/{id}', [LaporanAnalisController::class, 'update'])->name('laporan-analis.update');

    Route::post(
        '/indikator/{indikator}/active',
        [IndikatorPeriodeController::class, 'active']
    )->name('indikator.active');
});
