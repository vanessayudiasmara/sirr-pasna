<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    KriteriaController,
    AlternatifController,
    ArasController,
    ProyekController,
    ProfileController,
    LaporanController,
    UserController,
    Master\DesaController,
    Master\JenisBencanaController,
    Master\JenisInfrastrukturController,
    Master\JenisKriteriaController,
    Master\KecamatanController,
    Master\KewenanganAsetController,
    Master\SatuanController,
    Master\MasterProyekController,
    Auth\PasswordController,
};


// Redirect root ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {

    // =============================
    // COMMON (USER + SUPERADMIN)
    // =============================

    Route::get('/dashboard', [DashboardController::class,'index'])
        ->name('dashboard');

    Route::get('/data-prioritas-proyek', [ArasController::class,'daftar'])
        ->name('prioritas.index');

    Route::get('/proyek/{alternatif}', [ProyekController::class,'show'])
        ->name('proyek.show');

    // =============================
    // DATA KERUSAKAN
    // =============================

    Route::get('/data-kerusakan', [AlternatifController::class, 'index'])
        ->name('alternatif.index');



    // =============================
    // SUPERADMIN ONLY
    // =============================

    Route::middleware(['role:superadmin'])->group(function () {

        // =============================
        // DATA KERUSAKAN (FULL ACCESS)
        // =============================

        // IMPORTANT:
        // route spesifik HARUS di atas route parameter

        Route::get('/data-kerusakan/create', [AlternatifController::class,'create'])
            ->name('alternatif.create');

        Route::post('/data-kerusakan', [AlternatifController::class,'store'])
            ->name('alternatif.store');

        Route::get('/data-kerusakan/{alternatif}/edit', [AlternatifController::class,'edit'])
            ->name('alternatif.edit');

        Route::put('/data-kerusakan/{alternatif}', [AlternatifController::class,'update'])
            ->name('alternatif.update');

        Route::delete('/data-kerusakan/{alternatif}', [AlternatifController::class,'destroy'])
            ->name('alternatif.destroy');

        // MASTER DATA
        Route::resource('kriteria', KriteriaController::class)
            ->parameters(['kriteria' => 'kriteria']);

        Route::resource('users', UserController::class);

        // ARAS
        Route::get('/aras/hasil', [ArasController::class,'hasil'])
            ->name('aras.hasil');

        // MANAJEMEN PROYEK
        Route::get('/proyek', [ProyekController::class,'index'])
            ->name('proyek.index');

        Route::patch('/proyek/{proyek}/status', [ProyekController::class,'updateStatus'])
            ->name('proyek.updateStatus');

        // LAPORAN
        Route::get('/laporan', [LaporanController::class,'index'])
            ->name('laporan.index');

        Route::get('/laporan/preview', [LaporanController::class, 'preview'])
            ->name('laporan.preview');

        Route::post('/laporan/export', [LaporanController::class,'export'])
            ->name('laporan.export');

        // DATA MASTER
        Route::resource('kecamatan', KecamatanController::class);
        Route::resource('desa', DesaController::class);
        Route::resource('jenis-bencana', JenisBencanaController::class);
        Route::resource('jenis-infrastruktur', JenisInfrastrukturController::class);
        Route::resource('satuan', SatuanController::class);

        Route::resource('jenis-kriteria', JenisKriteriaController::class)
            ->parameters([
                'jenis-kriteria' => 'jenis_kriteria'
            ]);

        Route::resource('kewenangan-aset', KewenanganAsetController::class);

        Route::resource('master-proyek', MasterProyekController::class);

    });

    // =============================
    // SHOW DETAIL
    // TARUH PALING BAWAH
    // =============================

    Route::get('/data-kerusakan/{alternatif}', [AlternatifController::class, 'show'])
        ->name('alternatif.show');



    // =============================
    // PROFILE
    // =============================

    Route::get('/profile', [ProfileController::class,'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class,'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class,'destroy'])
        ->name('profile.destroy');

    Route::put('/password', [PasswordController::class, 'update'])
        ->name('password.update');
        
    Route::get('/profile/security', [ProfileController::class, 'security'])
        ->name('profile.security');

    Route::put('/profile/security', [PasswordController::class, 'update'])
        ->name('password.update');

});

require __DIR__.'/auth.php';