<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\SuperadminPendudukController;
use App\Http\Controllers\SuperAdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', DashboardController::class)->name('dashboard');

Route::name('frontend.')->group(function () {
    Route::get('home', [FrontEndController::class, 'index'])->name('home');
});

Route::prefix('master')->name('master.')->group(function () {

    Route::prefix('user')
        ->name('user.')
        ->group(function () {

        Route::get('', [SuperAdminUserController::class, 'index'])->name('index');
        Route::get('datatable', [SuperAdminUserController::class, 'datatable'])->name('datatable');
    });

    Route::prefix('penduduk')
        ->name('penduduk.')
        ->group(function () {

        Route::resource('', SuperadminPendudukController::class);
        Route::get('datatable', [SuperadminPendudukController::class, 'datatable'])->name('datatable');
        Route::delete('pendudukDestroy/{id}', [SuperadminPendudukController::class, 'pendudukDestroy'])->name('pendudukDestroy');
    });

});

