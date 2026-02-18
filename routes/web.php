<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\UserRedirectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SystemConfigController;
use App\Http\Controllers\Admin\DataItemController;

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
            Route::GET('/dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
        });
        Route::prefix('setting')->group(function () {
            Route::GET('/website', [SystemConfigController::class, 'index'])->name('setting.website');
            Route::GET('/website/json', [SystemConfigController::class, 'json']);
            Route::GET('/website/find/{id}', [SystemConfigController::class, 'find']);
        });

        Route::prefix('main')->group(function () {
            Route::prefix('items')->group(function () {
                Route::GET('/', [DataItemController::class, 'index'])->name('master.data.items');
                Route::GET('/edit/{id}', [DataItemController::class, 'index'])->name('master.data.items');
                Route::GET('/json', [DataItemController::class, 'json']);
                Route::GET('/find/{id}', [DataItemController::class, 'find']);
            });
        });

        Route::GET('/p2h/form', function () {
            return view('p2h.form');
        })->name('p2h.form');

    });
});

Route::get('/', function () {
    return view('welcome');
});
