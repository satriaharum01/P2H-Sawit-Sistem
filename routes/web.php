<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\UserRedirectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SystemConfigController;
use App\Http\Controllers\Admin\DataItemController;
use App\Http\Controllers\Admin\DataAttributesController;
use App\Http\Controllers\Admin\ItemAttributesController;
//Operations
use App\Http\Controllers\Operation\TaskMonitorController;
use App\Http\Controllers\Operation\OperatorTaskController;
use App\Http\Controllers\Operation\OperationDashboardController;

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
Route::prefix('auth')->name('auth.')->group(function () {
    Route::POST('/logout', [CustomAuthController::class, 'logout'])->name('logout');
    Route::GET('/logout', [CustomAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['check.maintenance'])->group(function () {
    Route::middleware(['auth', 'check.route'])->group(function () {

        Route::GET('/user/redirect', [UserRedirectController::class, 'redirect'])->name('users.redirect');

        Route::prefix('account')->group(function () {
            Route::GET('/dashboard', [DashboardController::class, 'index'])->name('account.dashboard');
            Route::GET('/operation/dashboard', [OperationDashboardController::class, 'index'])->name('account.operation.dashboard');
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
                Route::POST('/update/{id}', [DataItemController::class, 'update'])->name('master.data.items.update');
                Route::GET('/json', [DataItemController::class, 'json']);
                Route::GET('/find/{id}', [DataItemController::class, 'find']);
            });

            Route::prefix('attributes')->group(function () {
                Route::GET('/', [DataAttributesController::class, 'index'])->name('master.data.attributes');
                Route::GET('/add', [DataAttributesController::class, 'add'])->name('master.data.attributes.add');
                Route::GET('/edit/{id}', [DataAttributesController::class, 'edit'])->name('master.data.attributes.edit');
                Route::GET('/delete/{id}', [DataAttributesController::class, 'delete'])->name('master.data.attributes.delete');
                Route::POST('/store', [DataAttributesController::class, 'store'])->name('master.data.attributes.store');
                Route::POST('/update/{id}', [DataAttributesController::class, 'update'])->name('master.data.attributes.update');
                Route::GET('/json', [DataAttributesController::class, 'json']);
                Route::GET('/find/{id}', [DataAttributesController::class, 'find']);
            });

            Route::prefix('item-attributes')->group(function () {
                Route::GET('/', [ItemAttributesController::class, 'index'])->name('master.data.itemattributes');
                Route::GET('/add', [ItemAttributesController::class, 'add'])->name('master.data.itemattributes.attach');
                Route::GET('/show/{id}', [ItemAttributesController::class, 'detail'])->name('master.data.itemattributes.detail');
                Route::GET('/show/{od}/delete/{id}', [ItemAttributesController::class, 'delete'])->name('master.data.itemattributes.delete');
                Route::POST('/store', [ItemAttributesController::class, 'store'])->name('master.data.itemattributes.store');
                Route::POST('/update/{id}', [ItemAttributesController::class, 'update'])->name('master.data.itemattributes.update');
                Route::GET('/json', [ItemAttributesController::class, 'json']);
                Route::GET('/show/{id}/json', [ItemAttributesController::class, 'getParamaters']);
                Route::GET('/show/{od}/find/{id}', [ItemAttributesController::class, 'find']);
            });
        });

        Route::prefix('operation')->name('operation.')->group(function () {
            Route::GET('/dashboard', [OperationDashboardController::class, 'index'])->name('dashboard');

            Route::prefix('task')->name('task.')->group(function () {
                Route::GET('/', [OperatorTaskController::class, 'index'])->name('index');
                Route::GET('/add', [OperatorTaskController::class, 'add'])->name('add');
                Route::GET('/show/{id}', [OperatorTaskController::class, 'detail'])->name('detail');
                Route::GET('/show/{id}', [OperatorTaskController::class, 'detail'])->name('detail');
                Route::POST('/submit', [OperatorTaskController::class, 'submit'])->name('submit');
                Route::GET('/json', [OperatorTaskController::class, 'json']);

                Route::GET('/history', [OperatorTaskController::class, 'history'])->name('history');
                Route::GET('/history/json', [TaskMonitorController::class, 'historyJson']);

            });

            Route::prefix('p2h')->name('p2h.')->group(function () {
                Route::prefix('task')->name('task.')->group(function () {
                    Route::GET('/', [TaskMonitorController::class, 'index'])->name('index');
                    Route::GET('/add', [TaskMonitorController::class, 'add'])->name('add');
                    Route::GET('/edit/{id}', [TaskMonitorController::class, 'edit'])->name('edit');
                    Route::GET('/show/{id}', [TaskMonitorController::class, 'detail'])->name('detail');
                    Route::GET('/show/{od}/delete/{id}', [TaskMonitorController::class, 'delete'])->name('delete');
                    Route::POST('/store', [TaskMonitorController::class, 'store'])->name('store');
                    Route::POST('/update/{id}', [TaskMonitorController::class, 'update'])->name('update');
                    Route::GET('/json', [TaskMonitorController::class, 'json']);
                    Route::GET('/show/{id}/json', [TaskMonitorController::class, 'getParamaters']);
                    Route::GET('/show/{od}/find/{id}', [TaskMonitorController::class, 'find']);
                });
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
