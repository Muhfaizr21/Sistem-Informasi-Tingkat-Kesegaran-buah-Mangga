<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $petani = Petani::firstOrCreate(['pengguna_id' => auth()->id()]);

        // Ambil pesanan yang berisi produk dari petani ini
        $query = Pesanan::whereHas('items.listing', function ($query) use ($petani) {
            $query->where('petani_id', $petani->id);
        })->with(['pembeli.user', 'alamat.kecamatan', 'items' => function($query) use ($petani) {
            $query->whereHas('listing', function($q) use ($petani) {
                $q->where('petani_id', $petani->id);
            })->with('listing');
        }]);

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Shipping Package
        if ($request->filled('pengiriman')) {
            $query->where('metode_pengiriman', $request->pengiriman);
        }

        $pesanans = $query->latest()->get();

        return view('petani.pesanan.index', compact('pesanans'));
    }

    public function updateStatus(Request $request, $id)
    {
        $petani = Petani::firstOrCreate(['pengguna_id' => auth()->id()]);
        $pesanan = Pesanan::whereHas('items.listing', function ($query) use ($petani) {
            $query->where('petani_id', $petani->id);
        })->findOrFail($id);

        $request->validate([
            'status' => 'required|in:dikemas,dikirim'
        ]);

        $pesanan->update([
            'status' => $request->status,
            'dikirim_pada' => $request->status === 'dikirim' ? now() : $pesanan->dikirim_pada
        ]);

        $statusLabel = $request->status === 'dikemas' ? 'Sedang Dikemas' : 'Dalam Pengiriman';

        \App\Models\Notifikasi::send(
            $pesanan->pembeli->pengguna_id,
            'update_status_pesanan',
            "Pesanan {$statusLabel}! 📦",
            "Pesanan {$pesanan->kode_pesanan} Anda saat ini {$statusLabel}. Pantau terus perjalanannya.",
            'pesanan',
            $pesanan->id
        );

        return redirect()->back()->with('success', "Status pesanan berhasil diperbarui ke {$statusLabel}.");
    }
}
