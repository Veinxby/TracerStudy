<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\admin\DataMhsController;
use App\Http\Controllers\admin\DataPerusahaanController;
use App\Http\Controllers\admin\InterviewController;
use App\Http\Controllers\admin\JurusanController;
use App\Http\Controllers\admin\KelasController;
use App\Http\Controllers\admin\KerjaController;
use App\Http\Controllers\admin\MagangController;
use App\Http\Controllers\admin\PenempatanController;
use App\Http\Controllers\admin\PermintaanController;
use App\Http\Controllers\admin\PermintaanKandidatController;
use App\Http\Controllers\bm\BranchManagerDashboardController;
use App\Http\Controllers\mhs\MahasiswaDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;


/*
|--------------------------------------------------------------------------
| AUTH (LOGIN & LOGOUT)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD PER ROLE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('adm')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Data Mahasiswa
        Route::get('search-mahasiswa', [DataMhsController::class, 'searchMahasiswa'])->name('mahasiswa.searchMhs');
        Route::get('data-mhs/detail/{nipd}', [DataMhsController::class, 'detail'])->name('mahasiswa.detail');
        Route::post('data-mhs/import', [DataMhsController::class, 'import'])->name('mahasiswa.import');
        Route::post('data-mhs/update-status/{id}', [DataMhsController::class, 'updateStatus']);
        Route::resource('data-mhs', DataMhsController::class);

        Route::middleware('role:educ,it')->group(function () {
            // Data Jurusan
            Route::resource('jurusan', JurusanController::class);

            Route::prefix('jurusan/{kode}')
                ->name('jurusan.')
                ->group(function () {

                    Route::get('kelas/{kelas}/mahasiswa', [KelasController::class, 'byKelas'])
                        ->name('kelas.mahasiswa');

                    Route::resource('kelas', KelasController::class);
                });
        });


        Route::middleware('role:adm_tracer,it')->group(function () {

            // Perusahaan
            Route::get('perusahaan/search', [DataPerusahaanController::class, 'search'])->name('perusahaan.search');
            Route::post('data-perusahaan/import', [DataPerusahaanController::class, 'import'])->name('data-perusahaan.import');
            Route::resource('data-perusahaan', DataPerusahaanController::class);

            Route::post('permintaan/{id}/unlock', [PermintaanController::class, 'unlock'])->name('permintaan.unlock');
            Route::get('permintaan/generate-kode', [PermintaanController::class, 'generateKode'])->name('permintaan.generateKode');
            Route::resource('permintaan', PermintaanController::class);

            // Permintaan Kandidat
            Route::prefix('permintaan/{permintaan}')
                ->name('permintaan.')
                ->group(function () {

                    Route::get('kandidat', [PermintaanKandidatController::class, 'index'])
                        ->name('kandidat.index');

                    Route::get('kandidat/create', [PermintaanKandidatController::class, 'create'])
                        ->name('kandidat.create');

                    Route::post('kandidat', [PermintaanKandidatController::class, 'store'])
                        ->name('kandidat.store');

                    Route::get('kandidat/{kandidat}/edit', [PermintaanKandidatController::class, 'edit'])
                        ->name('kandidat.edit');

                    Route::put('kandidat/{kandidat}', [PermintaanKandidatController::class, 'update'])
                        ->name('kandidat.update');

                    Route::delete('kandidat/{kandidat}', [PermintaanKandidatController::class, 'destroy'])
                        ->name('kandidat.destroy');

                    Route::get('search-mahasiswa', [PermintaanKandidatController::class, 'searchMahasiswa'])
                        ->name('kandidat.searchMahasiswa');

                    // ROUTE BARU UNTUK PROSES HASIL
                    Route::get('proses-kandidat', [PermintaanKandidatController::class, 'proses'])
                        ->name('kandidat.proses');

                    Route::post('proses', [PermintaanKandidatController::class, 'prosesStore'])
                        ->name('kandidat.proses.store');
                });
        });


        // Tracer
        // Interview
        Route::post('interviews/import', [InterviewController::class, 'import'])->name('interview.import');
        Route::resource('interviews', InterviewController::class);

        // Penempatan
        Route::put('penempatan/{penempatan}/update-status', [PenempatanController::class, 'updateStatus'])->name('penempatan.updateStatus');
        Route::post('penempatan/import', [PenempatanController::class, 'import'])->name('penempatan.import');
        Route::resource('penempatan', PenempatanController::class);
        // Magang
        Route::post('magang/import', [MagangController::class, 'import'])->name('magang.import');
        Route::resource('magang', MagangController::class);

        // Kerja
        Route::post('kerja/import', [KerjaController::class, 'import'])->name('kerja.import');
        Route::resource('kerja', KerjaController::class);
    });


Route::middleware(['auth', 'role:mhs'])->group(function () {
    Route::get('/mhs/dashboard', [MahasiswaDashboardController::class, 'index'])
        ->name('mahasiswa.dashboard');
});


Route::middleware(['auth', 'role:bm'])->group(function () {
    Route::get('/bm/dashboard', [BranchManagerDashboardController::class, 'index'])
        ->name('bm.dashboard');
});
