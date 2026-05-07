<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MidtransCallbackController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handleNotification']);

Route::get('/', function () {
    return view('landing');
})->name('landing');

use App\Http\Controllers\Pembeli\DashboardController as PembeliDashboard;
use App\Http\Controllers\Pembeli\ReviewController;
use App\Http\Controllers\Pembeli\BuyerController;
use App\Http\Controllers\Pembeli\FavoritController;
use App\Http\Controllers\Pembeli\NotificationController;

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'pembeli') {
        return redirect()->route('pembeli.dashboard');
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
    
    // Pesanan & Verifikasi Pembayaran
    Route::get('/pesanan', [AdminController::class, 'pesanan'])->name('pesanan.index');
    Route::get('/verifikasi-pembayaran', [AdminController::class, 'verifikasiPembayaran'])->name('verifikasi-pembayaran');
    Route::post('/pesanan/{id}/konfirmasi', [AdminController::class, 'konfirmasiPembayaran'])->name('pesanan.konfirmasi');
    Route::post('/pesanan/{id}/tolak', [AdminController::class, 'tolakPembayaran'])->name('pesanan.tolak');
});

use App\Http\Controllers\Pembeli\ScanController as PembeliScan;
use App\Http\Controllers\Pembeli\MarketplaceController;
use App\Http\Controllers\Pembeli\CartController;
use App\Http\Controllers\Pembeli\CheckoutController;
use App\Http\Controllers\Pembeli\PetaniController as PembeliPetani;
use App\Http\Controllers\Pembeli\AddressController;
use App\Http\Controllers\Pembeli\OrderController as PembeliOrder;

Route::prefix('pembeli')->name('pembeli.')->middleware(['auth', 'pembeli'])->group(function () {
    Route::get('/dashboard', [PembeliDashboard::class, 'index'])->name('dashboard');
    Route::get('/scan', [PembeliScan::class, 'index'])->name('scan');
    Route::post('/scan/proses', [PembeliScan::class, 'proses'])->name('scan.proses');
    Route::post('/scan/simpan', [PembeliScan::class, 'simpan'])->name('scan.simpan');
    Route::post('/scan/batal', [PembeliScan::class, 'batal'])->name('scan.batal');

    // Marketplace
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.katalog');
    Route::get('/marketplace/mangga/{id}', [MarketplaceController::class, 'show'])->name('marketplace.detail');
    Route::get('/marketplace/petani/{id}', [PembeliPetani::class, 'show'])->name('marketplace.petani');

    // Cart
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::post('/keranjang/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/keranjang/hapus', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/proses', [CheckoutController::class, 'process'])->name('checkout.process');

    // Alamat
    Route::get('/alamat', [AddressController::class, 'index'])->name('alamat.index');
    Route::post('/alamat', [AddressController::class, 'store'])->name('alamat.store');
    Route::put('/alamat/{id}', [AddressController::class, 'update'])->name('alamat.update');
    Route::delete('/alamat/{id}', [AddressController::class, 'destroy'])->name('alamat.destroy');
    Route::post('/alamat/{id}/utama', [AddressController::class, 'setUtama'])->name('alamat.utama');

    // Scan History
    Route::get('/riwayat-scan', [BuyerController::class, 'scanHistory'])->name('scan.history');
    Route::delete('/riwayat-scan/{id}', [BuyerController::class, 'destroyScan'])->name('scan.destroy');

    // Notifikasi
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifikasi/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifikasi/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    // Favorit Petani
    Route::post('/favorit/toggle', [FavoritController::class, 'toggle'])->name('favorit.toggle');

    // Pesanan (Tracking & History)
    Route::get('/pesanan', [PembeliOrder::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PembeliOrder::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{id}/bayar', [PembeliOrder::class, 'pay'])->name('pesanan.bayar');
    Route::post('/pesanan/{id}/batal', [PembeliOrder::class, 'cancel'])->name('pesanan.batal');
    Route::post('/pesanan/{id}/update-payment-method', [PembeliOrder::class, 'updatePaymentMethod'])->name('pesanan.update-payment-method');
    Route::post('/pesanan/{id}/selesai', [PembeliOrder::class, 'konfirmasiSelesai'])->name('pesanan.selesai');
    Route::post('/pesanan/{id}/review', [ReviewController::class, 'store'])->name('pesanan.review');
});

use App\Http\Controllers\petani\PetaniController;
use App\Http\Controllers\petani\DashboardController;
use App\Http\Controllers\petani\LahanController;
use App\Http\Controllers\petani\ScanKesegaranController;
use App\Http\Controllers\petani\LaporanPanenController;
use App\Http\Controllers\petani\WilayahProduksiController;
use App\Http\Controllers\petani\ProfileController as PetaniProfileController;
use App\Http\Controllers\petani\RekomendasiController;

Route::prefix('petani')->name('petani.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/wilayah-produksi', [WilayahProduksiController::class, 'index'])->name('wilayah-produksi');
    Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi');
    
    // Scan Kesegaran
    Route::get('/cek-kesegaran', [ScanKesegaranController::class, 'index'])->name('cek-kesegaran');
    Route::post('/cek-kesegaran/analyze', [ScanKesegaranController::class, 'analyze'])->name('cek-kesegaran.analyze');
    Route::post('/cek-kesegaran/store', [ScanKesegaranController::class, 'store'])->name('cek-kesegaran.store');
    
    // Lahan Management
    Route::get('/data-lahan', [LahanController::class, 'index'])->name('data-lahan');
    Route::post('/data-lahan', [LahanController::class, 'store'])->name('data-lahan.store');
    Route::put('/data-lahan/{lahan}', [LahanController::class, 'update'])->name('data-lahan.update');
    Route::delete('/data-lahan/{lahan}', [LahanController::class, 'destroy'])->name('data-lahan.destroy');
    Route::post('/kecamatan/sync', [LahanController::class, 'syncKecamatan'])->name('kecamatan.sync');

    // Laporan Panen
    Route::get('/laporan-panen', [LaporanPanenController::class, 'index'])->name('laporan-panen');
    Route::post('/laporan-panen', [LaporanPanenController::class, 'store'])->name('laporan-panen.store');
    Route::put('/laporan-panen/{laporan}', [LaporanPanenController::class, 'update'])->name('laporan-panen.update');

    // Profile Management
    Route::get('/profil', [PetaniProfileController::class, 'index'])->name('profil');
    Route::put('/profil', [PetaniProfileController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [PetaniProfileController::class, 'updatePassword'])->name('profil.password');
    Route::post('/profil/documents', [PetaniProfileController::class, 'uploadDocuments'])->name('profil.documents');

    // Marketplace Management (Produk)
    Route::get('/produk', [\App\Http\Controllers\petani\ProdukController::class, 'index'])->name('produk.index');
    Route::delete('/produk/{id}', [\App\Http\Controllers\petani\ProdukController::class, 'destroy'])->name('produk.destroy');
    Route::post('/produk/{id}/toggle', [\App\Http\Controllers\petani\ProdukController::class, 'toggleStatus'])->name('produk.toggle');

    // Notifications
    Route::post('/notifikasi/{id}/read', [\App\Http\Controllers\petani\NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::delete('/notifikasi/{id}', [\App\Http\Controllers\petani\NotifikasiController::class, 'markAsRead'])->name('notifikasi.destroy');
    Route::post('/notifikasi/read-all', [\App\Http\Controllers\petani\NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');

    // Pesanan Management
    Route::get('/pesanan', [\App\Http\Controllers\petani\OrderController::class, 'index'])->name('pesanan.index');
    Route::post('/pesanan/{id}/status', [\App\Http\Controllers\petani\OrderController::class, 'updateStatus'])->name('pesanan.status');
});
