<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Koordinator\Dashboard as KoordinatorDashboard;
use App\Livewire\Mahasiswa\DashboardMahasiswa;
use App\Livewire\Mahasiswa\TargetTabungan;
use App\Livewire\Mahasiswa\Transaksi;
use App\Livewire\Mahasiswa\Konsultasi;
use App\Livewire\Mahasiswa\Notifikasi;
use App\Livewire\Mahasiswa\Profil;
use App\Livewire\Koordinator\PersetujuanTransaksi;
use App\Livewire\Koordinator\RiwayatTransaksi;
use App\Livewire\Koordinator\KonsultasiMahasiswa;
use App\Livewire\Koordinator\ProgressMahasiswa;
use App\Livewire\Koordinator\LaporanKeuangan;
use App\Livewire\Koordinator\Profil as KoordinatorProfil;

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
        Route::get('/kategori', \App\Livewire\Admin\KelolaKategori::class)->name('admin.kategori');
        Route::get('/semua-transaksi', \App\Livewire\Admin\SemuaTransaksi::class)->name('admin.semua-transaksi');
        Route::get('/persetujuan-transaksi', \App\Livewire\Admin\PersetujuanTransaksi::class)->name('admin.persetujuan-transaksi');
        Route::get('/laporan-keuangan', \App\Livewire\Admin\LaporanKeuangan::class)->name('admin.laporan-keuangan');
        Route::get('/notifikasi', \App\Livewire\Admin\Notifikasi::class)->name('admin.notifikasi');
        Route::get('/profil', \App\Livewire\Admin\Profil::class)->name('admin.profil');
    });

    Route::prefix('koordinator')->middleware('role:koordinator')->group(function () {
        Route::get('/dashboard', \App\Livewire\Koordinator\DashboardKoordinator::class)->name('koordinator.dashboard');
        Route::get('/progress-mahasiswa', \App\Livewire\Koordinator\ProgressMahasiswa::class)->name('koordinator.progress-mahasiswa');
        Route::get('/persetujuan-transaksi', \App\Livewire\Koordinator\PersetujuanTransaksi::class)->name('koordinator.persetujuan-transaksi');
        Route::get('/riwayat-transaksi', \App\Livewire\Koordinator\RiwayatTransaksi::class)->name('koordinator.riwayat-transaksi');
        Route::get('/konsultasi-mahasiswa', \App\Livewire\Koordinator\KonsultasiMahasiswa::class)->name('koordinator.konsultasi-mahasiswa');
        Route::get('/laporan-keuangan', \App\Livewire\Koordinator\LaporanKeuangan::class)->name('koordinator.laporan-keuangan');
        Route::get('/profil', \App\Livewire\Koordinator\Profil::class)->name('koordinator.profil');
    });

    // MAHASISWA
    Route::prefix('mahasiswa')->middleware('role:mahasiswa')->group(function () {
        Route::get('/dashboard', \App\Livewire\Mahasiswa\DashboardMahasiswa::class)->name('mahasiswa.dashboard');
        Route::get('/target-tabungan', \App\Livewire\Mahasiswa\TargetTabungan::class)->name('mahasiswa.target-tabungan');
        Route::get('/transaksi', \App\Livewire\Mahasiswa\Transaksi::class)->name('mahasiswa.transaksi');
        Route::get('/konsultasi', \App\Livewire\Mahasiswa\Konsultasi::class)->name('mahasiswa.konsultasi');
        Route::get('/notifikasi', \App\Livewire\Mahasiswa\Notifikasi::class)->name('mahasiswa.notifikasi');
        Route::get('/profil', \App\Livewire\Mahasiswa\Profil::class)->name('mahasiswa.profil');
    });
});

// ----------------------------------------------------
// 👇 Tes RoleMiddleware
// ----------------------------------------------------
Route::get('/admin-only', fn() => 'Halo, Admin!')->middleware(['auth', 'role:admin']);
Route::get('/koordinator-only', fn() => 'Halo, Koordinator!')->middleware(['auth', 'role:koordinator']);
Route::get('/mahasiswa-only', fn() => 'Halo, Mahasiswa!')->middleware(['auth', 'role:mahasiswa']);