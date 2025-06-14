<?php

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

Route::get('/masuk', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::get('/daftar', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register');
Route::post('/daftar', [App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');

Route::get('/verify/{id}', [App\Http\Controllers\Auth\VerificationController::class, 'index'])->name('verify.index');
Route::post('/verify/{id}', [App\Http\Controllers\Auth\VerificationController::class, 'store'])->name('verify.store');

// Route::post('/masuk', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/keluar', [App\Http\Controllers\Auth\HrisController::class, 'logout'])->name('logout');

Route::redirect('/', '/masuk');

Route::get('/t/{url}', [App\Http\Controllers\Toko\LandingController::class, 'show'])->name('lihatToko');
Route::get('/t/{url}/mock', [App\Http\Controllers\Toko\LandingController::class, 'mockData'])->name('lihatToko.mockData');


// Route Login HRIS
Route::get('/loginnya', [App\Http\Controllers\Auth\HrisController::class, 'index']);
Route::post('/loginHris', [App\Http\Controllers\Auth\HrisController::class, 'store'])->name('loginHris');

require __DIR__ . '/admin.php';
require __DIR__ . '/users.php';
require __DIR__ . '/masterData.php';
