<?php

use Illuminate\Support\Facades\Route;

Route::prefix('masterData')->name('masterData.')->middleware(['auth'])->group(function () {
    Route::prefix('masterPackage')->name('masterPackage.')->group(function () {
        Route::get('', [App\Http\Controllers\MasterData\MasterPackageController::class, 'index'])->name('index');
        // Route::post('', [App\Http\Controllers\Admin\BannerController::class, 'store'])->name('store');
        // Route::delete('{id}', [App\Http\Controllers\Admin\BannerController::class, 'destroy'])->name('destroy');
    });

});
