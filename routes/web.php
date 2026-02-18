<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\UserRedirectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SystemConfigController;
use App\Http\Controllers\Admin\DataItemController;
use App\Http\Controllers\Admin\DataAttributesController;

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
                Route::GET('/add', [DataItemController::class, 'add'])->name('master.data.items.add');
                Route::GET('/edit/{id}', [DataItemController::class, 'edit'])->name('master.data.items.edit');
                Route::GET('/delete/{id}', [DataItemController::class, 'delete'])->name('master.data.items.delete');
                Route::POST('/store', [DataItemController::class, 'store'])->name('master.data.items.store');
                Route::GET('/update/{id}', [DataItemController::class, 'update'])->name('master.data.items.update');
                Route::GET('/json', [DataItemController::class, 'json']);
                Route::GET('/find/{id}', [DataItemController::class, 'find']);
            });
            Route::prefix('attributes')->group(function () {
                Route::GET('/', [DataAttributesController::class, 'index'])->name('master.data.attributes');
                Route::GET('/add', [DataAttributesController::class, 'add'])->name('master.data.attributes.add');
                Route::GET('/edit/{id}', [DataAttributesController::class, 'edit'])->name('master.data.attributes.edit');
                Route::GET('/delete/{id}', [DataAttributesController::class, 'delete'])->name('master.data.attributes.delete');
                Route::POST('/store', [DataAttributesController::class, 'store'])->name('master.data.attributes.store');
                Route::GET('/update/{id}', [DataAttributesController::class, 'update'])->name('master.data.attributes.update');
                Route::GET('/json', [DataAttributesController::class, 'json']);
                Route::GET('/find/{id}', [DataAttributesController::class, 'find']);
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
