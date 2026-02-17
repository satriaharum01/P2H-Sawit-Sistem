<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\UserRedirectController;

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
Route::middleware('guest')->group(function () {
    Route::GET('/auth', [CustomAuthController::class, 'showLogin'])->name('auth.login');
    Route::POST('/auth', [CustomAuthController::class, 'login'])->name('auth.process');
});

Route::POST('/logout', [CustomAuthController::class, 'logout'])->name('logout');

Route::middleware(['check.maintenance'])->group(function () {
    Route::middleware(['auth', 'check.route'])->group(function () {

        Route::GET('/user/redirect', [UserRedirectController::class, 'redirect']);

        Route::prefix('account')->group(function () {
            Route::GET('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
                ->name('account.dashboard');
        });

        Route::GET('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::GET('/p2h/form', function () {
            return view('p2h.form');
        })->name('p2h.form');

    });
});

Route::get('/', function () {
    return view('welcome');
});
