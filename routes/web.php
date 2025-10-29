<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Koordinator\Dashboard as KoordinatorDashboard;
use App\Livewire\Mahasiswa\DashboardMahasiswa;
use App\Livewire\Mahasiswa\TransaksiMahasiswa;
use App\Livewire\Mahasiswa\TabunganMahasiswa;
use App\Livewire\Mahasiswa\KonsultasiMahasiswa;

Route::view('/', 'welcome');

// ✅ Route utama setelah login
Route::middleware(['auth'])->get('/dashboard', function () {
    return redirect()->route('redirect');
})->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// ✅ Logout manual
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// ✅ Redirect sesuai role
Route::middleware(['auth'])->get('/redirect', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'koordinator' => redirect()->route('koordinator.dashboard'),
        'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
        default => abort(403),
    };
})->name('redirect');

// ✅ Grup route per role
Route::middleware(['auth'])->group(function () {

    // ADMIN
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', \App\Livewire\Admin\DashboardAdmin::class)->name('admin.dashboard');
        Route::get('/users', \App\Livewire\Admin\KelolaUser::class)->name('admin.users');
        Route::get('/kategori', \App\Livewire\Admin\KategoriTabungan::class)->name('admin.kategori');
        Route::get('/transaksi', \App\Livewire\Admin\DataTransaksi::class)->name('admin.transaksi');
        Route::get('/target-tabungan', \App\Livewire\Admin\TargetTabungan::class)->name('admin.target');
    });


    // KOORDINATOR
    Route::prefix('koordinator')->middleware('role:koordinator')->group(function () {
        Route::get('/dashboard', \App\Livewire\Koordinator\DashboardKoordinator::class)->name('koordinator.dashboard');
        Route::get('/data-mahasiswa', \App\Livewire\Koordinator\DataMahasiswa::class)->name('koordinator.data-mahasiswa');
        Route::get('/laporan-tabungan', \App\Livewire\Koordinator\LaporanTabungan::class)->name('koordinator.laporan-tabungan');
        Route::get('/catatan-konsultasi', \App\Livewire\Koordinator\CatatanKonsultasi::class)->name('koordinator.catatan-konsultasi');
    });

    // MAHASISWA
    Route::prefix('mahasiswa')->middleware('role:mahasiswa')->group(function () {
        Route::get('/dashboard', DashboardMahasiswa::class)->name('mahasiswa.dashboard');
        Route::get('/transaksi', TransaksiMahasiswa::class)->name('mahasiswa.transaksi');
        Route::get('/tabungan', TabunganMahasiswa::class)->name('mahasiswa.tabungan');
        Route::get('/konsultasi', KonsultasiMahasiswa::class)->name('mahasiswa.konsultasi');
    });
});

// ----------------------------------------------------
// 👇 Tes RoleMiddleware
// ----------------------------------------------------
Route::get('/admin-only', fn() => 'Halo, Admin!')->middleware(['auth', 'role:admin']);
Route::get('/koordinator-only', fn() => 'Halo, Koordinator!')->middleware(['auth', 'role:koordinator']);
Route::get('/mahasiswa-only', fn() => 'Halo, Mahasiswa!')->middleware(['auth', 'role:mahasiswa']);
