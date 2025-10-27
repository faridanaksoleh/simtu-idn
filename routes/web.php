<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

// ----------------------------------------------------
// 👇 Tambahkan bagian ini untuk ngetes RoleMiddleware
// ----------------------------------------------------
Route::get('/admin-only', function () {
    return 'Halo, Admin!';
})->middleware(['auth', 'role:admin']);

Route::get('/koordinator-only', function () {
    return 'Halo, Koordinator!';
})->middleware(['auth', 'role:koordinator']);

Route::get('/mahasiswa-only', function () {
    return 'Halo, Mahasiswa!';
})->middleware(['auth', 'role:mahasiswa']);
