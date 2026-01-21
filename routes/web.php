<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\ManajemenRoleController;
use App\Http\Controllers\ManajemenUnitController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\PDSAController;

use App\Http\Controllers\IndikatorMutu\KamusIndikatorController;
use App\Http\Controllers\IndikatorMutu\MasterIndikatorController;
use App\Http\Controllers\IndikatorMutu\LaporanAnalisIMPUController;
use App\Http\Controllers\IndikatorMutu\LaporanAnalisIMNController;
use App\Http\Controllers\IndikatorMutu\LaporanAnalisIMPRSController;

use App\Http\Controllers\ManajemenMutu\CakupanDataController;
use App\Http\Controllers\ManajemenMutu\DimensiMutuController;
use App\Http\Controllers\ManajemenMutu\KategoriIMPRSController;
use App\Http\Controllers\ManajemenMutu\FrekuensiAnalisisDataController;
use App\Http\Controllers\ManajemenMutu\FrekuensiPengumpulanDataController;
use App\Http\Controllers\ManajemenMutu\InterpretasiDataController;
use App\Http\Controllers\ManajemenMutu\MetodologiAnalisisDataController;
use App\Http\Controllers\ManajemenMutu\MetodologiPengumpulanDataController;
use App\Http\Controllers\ManajemenMutu\PublikasiDataController;

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
    Route::resource('laporan-analis-impu', LaporanAnalisIMPUController::class)
        ->middleware('check.role:laporan_analis_impu');
    Route::resource('laporan-analis-imprs', LaporanAnalisIMPRSController::class)
        ->middleware('check.role:laporan_analis_imprs');
    Route::resource('laporan-analis-imn', LaporanAnalisIMNController::class)
        ->middleware('check.role:laporan_analis_imn');
    Route::resource('kategori-imprs', KategoriIMPRSController::class)
        ->middleware('check.role:kategori_imprs');

    // Menu Manajemen Mutu
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

    // Hanya index dengan middleware check.role
    Route::get('/pdsa', [PDSAController::class, 'index'])
        ->name('pdsa.index')
        ->middleware('check.role:pdsa');

    // Tambahan route khusus
    Route::prefix('pdsa')->group(function () {

        // Halaman isi PDSA (unit / mutu melihat detail)
        Route::get('/show/{id}', [PDSAController::class, 'show'])->name('pdsa.show');

        // Halaman isi PDSA (unit / mutu melihat detail)
        Route::get('/fill/{id}', [PDSAController::class, 'show'])->name('pdsa.fill');

        // Unit submit PDSA
        Route::post('/submit/{id}', [PDSAController::class, 'submit'])->name('pdsa.submit');

        // Mutu approve PDSA
        Route::post('/approve/{id}', [PDSAController::class, 'approve'])->name('pdsa.approve');

        // Mutu menugaskan PDSA
        Route::post('/store', [PDSAController::class, 'store'])->name('pdsa.store');

        // Unit menyimpan PDSA sementara (update plan/do/study/action)
        Route::post('/update/{id}', [PDSAController::class, 'updateByUnit'])->name('pdsa.update');

        // Mutu/Admin simpan edit
        Route::post('/update/mutu/{id}', [PDSAController::class, 'updateByMutu'])->name('pdsa.update.mutu');

        Route::post('/pdsa/{id}/update', [PDSAController::class, 'update'])->name('pdsa.update');

    });


    Route::resource('dashboard', DashboardController::class)
        ->middleware('check.role:dashboard');
});
