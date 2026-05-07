<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function users()
    {
        $users = \App\Models\User::where('id', '!=', auth()->id())->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function mapping()
    {
        return view('admin.mapping');
    }

    public function qualityMonitor()
    {
        return view('admin.quality-monitor');
    }

    public function harvestReport()
    {
        $reports = \App\Models\LaporanPanen::with('petani')->latest()->get();
        return view('admin.harvest-report', compact('reports'));
    }

    public function apiIntegration()
    {
        return view('admin.api-integration');
    }

    public function config()
    {
        return view('admin.config');
    }

    public function pesanan()
    {
        $pesanans = \App\Models\Pesanan::with(['pembeli.user', 'items.listing'])->latest()->get();
        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function verifikasiPembayaran()
    {
        $pesanans = \App\Models\Pesanan::with(['pembeli.user', 'items.listing'])
            ->where('status', 'menunggu_verifikasi')
            ->latest()
            ->get();
        return view('admin.pesanan.verifikasi', compact('pesanans'));
    }

    public function konfirmasiPembayaran(Request $request, $id)
    {
        $pesanan = \App\Models\Pesanan::findOrFail($id);
        
        $pesanan->update([
            'status' => 'dikonfirmasi',
            'catatan_admin' => $request->catatan
        ]);

        // Kurangi stok otomatis saat dikonfirmasi admin
        foreach ($pesanan->items as $item) {
            $listing = $item->listing;
            if ($listing) {
                $listing->decrement('stok_tersedia_kg', $item->jumlah_kg);
            }
        }

        \App\Models\Notifikasi::send(
            $pesanan->pembeli->pengguna_id,
            'pembayaran_dikonfirmasi',
            'Pembayaran Dikonfirmasi! ✅',
            "Pembayaran untuk pesanan {$pesanan->kode_pesanan} telah diverifikasi. Petani akan segera menyiapkan pesanan Anda.",
            'pesanan',
            $pesanan->id
        );

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function tolakPembayaran(Request $request, $id)
    {
        $pesanan = \App\Models\Pesanan::findOrFail($id);
        
        $pesanan->update([
            'status' => 'menunggu_bayar',
            'catatan_admin' => $request->catatan
        ]);

        \App\Models\Notifikasi::send(
            $pesanan->pembeli->pengguna_id,
            'pembayaran_ditolak',
            'Pembayaran Ditolak! ❌',
            "Pembayaran untuk pesanan {$pesanan->kode_pesanan} ditolak. Alasan: " . $request->catatan,
            'pesanan',
            $pesanan->id
        );

        return redirect()->back()->with('success', 'Pembayaran ditolak.');
    }
}
