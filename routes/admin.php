<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('', [App\Http\Controllers\V1\DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('notify')->name('notify.')->group(function () {
        Route::get('', [App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('store');
    });

    Route::prefix('banner')->name('banner.')->group(function () {
        Route::get('', [App\Http\Controllers\Admin\BannerController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\Admin\BannerController::class, 'store'])->name('store');
        Route::delete('{id}', [App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('permission')->name('permission.')->group(function () {
        Route::get('', [App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('index');
        Route::get('create', [App\Http\Controllers\Admin\PermissionController::class, 'create'])->name('create');
        Route::post('create', [App\Http\Controllers\Admin\PermissionController::class, 'store'])->name('store');
        Route::get('show/{id}', [App\Http\Controllers\Admin\PermissionController::class, 'show'])->name('show');
        Route::post('show/{id}', [App\Http\Controllers\Admin\PermissionController::class, 'update'])->name('update');
        Route::delete('show/{id}', [App\Http\Controllers\Admin\PermissionController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('', [App\Http\Controllers\Admin\MenuController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\Admin\MenuController::class, 'store'])->name('store');
        Route::delete('show/{id}', [App\Http\Controllers\Admin\MenuController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('pageSettings')->name('pageSettings.')->group(function () {
        Route::get('', [App\Http\Controllers\Admin\MaintenanceController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\Admin\MaintenanceController::class, 'store'])->name('store');
    });
});
