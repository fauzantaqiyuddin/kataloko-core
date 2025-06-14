<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->middleware('CheckToko', 'auth')->group(function () {
    Route::get('', [App\Http\Controllers\V1\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('toko')->name('toko.')->group(function () {
        Route::get('', [App\Http\Controllers\V1\TokoController::class, 'index'])->name('index');
        Route::get('checkUrl', [App\Http\Controllers\V1\TokoController::class, 'checkUrl'])->name('checkUrl');
        Route::post('', [App\Http\Controllers\V1\TokoController::class, 'tokoBaru'])->name('tokoBaru');
    });

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('', [App\Http\Controllers\V1\ProductController::class, 'index'])->name('index');
        Route::get('create', [App\Http\Controllers\V1\ProductController::class, 'create'])->name('create');
        Route::post('create', [App\Http\Controllers\V1\ProductController::class, 'store'])->name('store');
    });

    Route::get('manualBook', [App\Http\Controllers\V1\DashboardController::class, 'manualBook'])->name('master.manualBook');
    Route::post('readAll', [App\Http\Controllers\V1\NotificationController::class, 'readAll'])->name('readAll');

    Route::get('auditTrail', [App\Http\Controllers\V1\AuditTrailController::class, 'index'])->name('auditTrail');
    Route::post('auditTrail', [App\Http\Controllers\V1\AuditTrailController::class, 'generatePdf'])->name('auditTrail.generatePdf');
    Route::get('contactUs', [App\Http\Controllers\V1\ContactUsController::class, 'index'])->name('contactUs');
    Route::get('changeLog', [App\Http\Controllers\System\ChangeLogController::class, 'index'])->name('changeLog');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('', [App\Http\Controllers\V1\ProfileController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\V1\ProfileController::class, 'store'])->name('store');
    });
});
