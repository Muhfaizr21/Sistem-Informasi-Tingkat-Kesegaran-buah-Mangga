<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'buyer') {
        return redirect()->route('buyer.dashboard');
    } elseif ($role === 'petani') {
        return redirect()->route('petani.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\AdminController;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/mapping', [AdminController::class, 'mapping'])->name('mapping');
    Route::get('/quality-monitor', [AdminController::class, 'qualityMonitor'])->name('quality-monitor');
    Route::get('/harvest-report', [AdminController::class, 'harvestReport'])->name('harvest-report');
    Route::get('/api-integration', [AdminController::class, 'apiIntegration'])->name('api-integration');
    Route::get('/config', [AdminController::class, 'config'])->name('config');
});

use App\Http\Controllers\BuyerController;

Route::prefix('buyer')->name('buyer.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [BuyerController::class, 'dashboard'])->name('dashboard');
    Route::get('/catalog', [BuyerController::class, 'catalog'])->name('catalog');
    Route::get('/order-history', [BuyerController::class, 'orderHistory'])->name('order-history');
    Route::get('/checkout', [BuyerController::class, 'checkout'])->name('checkout');
    Route::get('/account-setting', [BuyerController::class, 'accountSetting'])->name('account-setting');
    Route::get('/market-analytics', [BuyerController::class, 'marketAnalytics'])->name('market-analytics');
});

use App\Http\Controllers\PetaniController;

Route::prefix('petani')->name('petani.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [PetaniController::class, 'dashboard'])->name('dashboard');
    Route::get('/cek-kesegaran', [PetaniController::class, 'cekKesegaran'])->name('cek-kesegaran');
    Route::get('/data-lahan', [PetaniController::class, 'dataLahan'])->name('data-lahan');
    Route::get('/laporan-panen', [PetaniController::class, 'laporanPanen'])->name('laporan-panen');
    Route::post('/laporan-panen', [PetaniController::class, 'storeLaporanPanen'])->name('laporan-panen.store');
    Route::get('/profil', [PetaniController::class, 'profil'])->name('profil');
});
