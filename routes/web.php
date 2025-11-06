<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Admin Components
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\KelolaUser;
use App\Livewire\Admin\KelolaKategori;
use App\Livewire\Admin\SemuaTransaksi;
use App\Livewire\Admin\PersetujuanTransaksi as AdminPersetujuanTransaksi;
use App\Livewire\Admin\LaporanKeuangan as AdminLaporanKeuangan;
use App\Livewire\Admin\Notifikasi as AdminNotifikasi;
use App\Livewire\Admin\Profil as AdminProfil;

// Koordinator Components
use App\Livewire\Koordinator\DashboardKoordinator;
use App\Livewire\Koordinator\ProgressMahasiswa;
use App\Livewire\Koordinator\PersetujuanTransaksi;
use App\Livewire\Koordinator\RiwayatTransaksi;
use App\Livewire\Koordinator\KonsultasiMahasiswa;
use App\Livewire\Koordinator\LaporanKeuangan;
use App\Livewire\Koordinator\Profil as KoordinatorProfil;

// Mahasiswa Components
use App\Livewire\Mahasiswa\DashboardMahasiswa;
use App\Livewire\Mahasiswa\TargetTabungan;
use App\Livewire\Mahasiswa\Transaksi;
use App\Livewire\Mahasiswa\Konsultasi;
use App\Livewire\Mahasiswa\Notifikasi;
use App\Livewire\Mahasiswa\Profil as MahasiswaProfil;

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
        default => redirect('/')->with('error', 'Role tidak dikenali'),
    };
})->name('redirect');

// ✅ Grup route per role
Route::middleware(['auth'])->group(function () {

    // ADMIN - Gunakan imported classes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', DashboardAdmin::class)->name('admin.dashboard');
        Route::get('/users', KelolaUser::class)->name('admin.users');
        Route::get('/kategori', KelolaKategori::class)->name('admin.kategori');
        Route::get('/semua-transaksi', SemuaTransaksi::class)->name('admin.semua-transaksi');
        Route::get('/persetujuan-transaksi', AdminPersetujuanTransaksi::class)->name('admin.persetujuan-transaksi');
        Route::get('/laporan-keuangan', AdminLaporanKeuangan::class)->name('admin.laporan-keuangan');
        Route::get('/notifikasi', AdminNotifikasi::class)->name('admin.notifikasi');
        Route::get('/profil', AdminProfil::class)->name('admin.profil');
    });

    // KOORDINATOR - Gunakan imported classes
    Route::prefix('koordinator')->middleware('role:koordinator')->group(function () {
        Route::get('/dashboard', DashboardKoordinator::class)->name('koordinator.dashboard');
        Route::get('/progress-mahasiswa', ProgressMahasiswa::class)->name('koordinator.progress-mahasiswa');
        Route::get('/persetujuan-transaksi', PersetujuanTransaksi::class)->name('koordinator.persetujuan-transaksi');
        Route::get('/riwayat-transaksi', RiwayatTransaksi::class)->name('koordinator.riwayat-transaksi');
        Route::get('/konsultasi-mahasiswa', KonsultasiMahasiswa::class)->name('koordinator.konsultasi-mahasiswa');
        Route::get('/laporan-keuangan', LaporanKeuangan::class)->name('koordinator.laporan-keuangan');
        Route::get('/profil', KoordinatorProfil::class)->name('koordinator.profil');
    });

    // MAHASISWA - Gunakan imported classes
    Route::prefix('mahasiswa')->middleware('role:mahasiswa')->group(function () {
        Route::get('/dashboard', DashboardMahasiswa::class)->name('mahasiswa.dashboard');
        Route::get('/target-tabungan', TargetTabungan::class)->name('mahasiswa.target-tabungan');
        Route::get('/transaksi', Transaksi::class)->name('mahasiswa.transaksi');
        Route::get('/konsultasi', Konsultasi::class)->name('mahasiswa.konsultasi');
        Route::get('/notifikasi', Notifikasi::class)->name('mahasiswa.notifikasi');
        Route::get('/profil', MahasiswaProfil::class)->name('mahasiswa.profil');
    });
});

// ----------------------------------------------------
// 👇 Tes RoleMiddleware (Optional - untuk development)
// ----------------------------------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/admin-only', fn() => 'Halo, Admin!')->middleware('role:admin');
    Route::get('/koordinator-only', fn() => 'Halo, Koordinator!')->middleware('role:koordinator');
    Route::get('/mahasiswa-only', fn() => 'Halo, Mahasiswa!')->middleware('role:mahasiswa');
});