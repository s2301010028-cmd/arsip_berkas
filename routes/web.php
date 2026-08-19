<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| SPLASH SCREEN
|--------------------------------------------------------------------------
|
| Halaman pertama ketika membuka website.
| Setelah 3 detik, splash.blade.php akan mengarahkan ke route login.
|
*/

Route::get('/', function () {

    /*
    |--------------------------------------------------------------------------
    | Kalau user SUDAH login
    |--------------------------------------------------------------------------
    |
    | Tidak perlu splash lagi.
    | Langsung ke Dashboard.
    |
    */

    if (auth()->check()) {

        return redirect()->route('dashboard');

    }


    /*
    |--------------------------------------------------------------------------
    | Kalau belum login
    |--------------------------------------------------------------------------
    */

    return view('splash');

})->name('home');


/*
|--------------------------------------------------------------------------
| SPLASH OPTIONAL ROUTE
|--------------------------------------------------------------------------
|
| Bisa juga dibuka langsung:
|
| /splash
|
*/

Route::get('/splash', function () {

    if (auth()->check()) {

        return redirect()->route('dashboard');

    }

    return view('splash');

})->name('splash');


/*
|--------------------------------------------------------------------------
| AUTH / LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');


Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTE YANG WAJIB LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    |
    | PERHATIAN:
    |
    | Route "/" tidak lagi berada di sini.
    | "/" sekarang digunakan untuk Splash Screen.
    |
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | NOTICE
    |--------------------------------------------------------------------------
    */

    Route::controller(NoticeController::class)->group(function () {


        /*
        |----------------------------------------------------------------------
        | DAFTAR NOTICE
        |----------------------------------------------------------------------
        */

        Route::get('/notice', 'index')
            ->name('notice.index');


        /*
        |----------------------------------------------------------------------
        | API NOTICE
        |----------------------------------------------------------------------
        */

        Route::get('/api/notices', 'apiIndex')
            ->name('api.notices');


        /*
        |----------------------------------------------------------------------
        | FORM INPUT NOTICE
        |----------------------------------------------------------------------
        */

        Route::get('/notice/create', 'create')
            ->name('notice.create');


        /*
        |----------------------------------------------------------------------
        | SIMPAN NOTICE
        |----------------------------------------------------------------------
        */

        Route::post('/notice', 'store')
            ->name('notice.store');


        /*
        |----------------------------------------------------------------------
        | FORM EDIT NOTICE
        |----------------------------------------------------------------------
        */

        Route::get('/notice/{id}/edit', 'edit')
            ->whereNumber('id')
            ->name('notice.edit');


        /*
        |----------------------------------------------------------------------
        | UPDATE NOTICE
        |----------------------------------------------------------------------
        */

        Route::put('/notice/{id}', 'update')
            ->whereNumber('id')
            ->name('notice.update');


        /*
        |----------------------------------------------------------------------
        | HAPUS NOTICE
        |----------------------------------------------------------------------
        */

        Route::delete('/notice/{id}', 'destroy')
            ->whereNumber('id')
            ->name('notice.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | ARSIP DIGITAL NOTICE
    |--------------------------------------------------------------------------
    */

    Route::controller(ArsipController::class)->group(function () {


        /*
        |----------------------------------------------------------------------
        | HALAMAN ARSIP
        |----------------------------------------------------------------------
        */

        Route::get('/arsip', 'index')
            ->name('arsip.index');


        /*
        |----------------------------------------------------------------------
        | RANGKUMAN ARSIP BULANAN
        |----------------------------------------------------------------------
        */

        Route::get(
            '/arsip/bulanan/{tahun}/{bulan}',
            'bulanan'
        )
            ->whereNumber('tahun')
            ->whereNumber('bulan')
            ->name('arsip.bulanan');


        /*
        |----------------------------------------------------------------------
        | DOWNLOAD EXCEL ARSIP BULANAN
        |----------------------------------------------------------------------
        */

        Route::get(
            '/arsip/bulanan/{tahun}/{bulan}/download',
            'exportBulanan'
        )
            ->whereNumber('tahun')
            ->whereNumber('bulan')
            ->name('arsip.bulanan.download');

    });


    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::controller(LaporanController::class)->group(function () {


        /*
        |----------------------------------------------------------------------
        | HALAMAN LAPORAN
        |----------------------------------------------------------------------
        */

        Route::get('/laporan', 'index')
            ->name('laporan.index');


        /*
        |----------------------------------------------------------------------
        | EXPORT EXCEL KESELURUHAN
        |----------------------------------------------------------------------
        */

        Route::get('/laporan/export', 'export')
            ->name('laporan.export');


        /*
        |----------------------------------------------------------------------
        | DOWNLOAD PDF PER BULAN
        |----------------------------------------------------------------------
        */

        Route::get('/laporan/pdf/{bulan}', 'downloadPdf')
            ->whereNumber('bulan')
            ->name('laporan.pdf');

    });


    /*
    |--------------------------------------------------------------------------
    | MANAJEMEN USER
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        Route::resource(
            'users',
            UserController::class
        );

    });


    /*
    |--------------------------------------------------------------------------
    | PROFILE / PENGATURAN AKUN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )
        ->name('profile.edit');


    Route::put(
        '/profile',
        [ProfileController::class, 'update']
    )
        ->name('profile.update');

});