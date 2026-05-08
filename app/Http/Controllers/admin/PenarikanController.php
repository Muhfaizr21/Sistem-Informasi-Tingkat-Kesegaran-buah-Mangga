<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenarikanDana;
use App\Models\Petani;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenarikanController extends Controller
{
    public function index()
    {
        // Ambil semua petani dan hitung total pendapatan & penarikan mereka
        $petanis = Petani::with(['user'])->get()->map(function($petani) {
            $petani->total_pendapatan = DetailPesanan::where('petani_id', $petani->id)
                ->whereHas('pesanan', function($q) {
                    $q->where('status', 'selesai');
                })
                ->sum('subtotal');
            
            $petani->total_ditarik = PenarikanDana::where('petani_id', $petani->id)
                ->where('status', 'disetujui')
                ->sum('nominal');
                
            $petani->saldo_tersedia = $petani->total_pendapatan - $petani->total_ditarik;
            
            $petani->pending_requests = PenarikanDana::where('petani_id', $petani->id)
                ->where('status', 'pending')
                ->count();
                
            return $petani;
        });

        // Ambil semua request pending
        $pendingRequests = PenarikanDana::with(['petani.user'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.penarikan.index', compact('petanis', 'pendingRequests'));
    }

    public function show($petani_id)
    {
        $petani = Petani::with(['user'])->findOrFail($petani_id);
        
        $riwayat = PenarikanDana::where('petani_id', $petani_id)
            ->latest()
            ->get();

        $totalPendapatan = DetailPesanan::where('petani_id', $petani_id)
            ->whereHas('pesanan', function($q) {
                $q->where('status', 'selesai');
            })
            ->sum('subtotal');

        return view('admin.penarikan.show', compact('petani', 'riwayat', 'totalPendapatan'));
    }

    public function action(Request $request, $id, $action)
    {
        $request->validate([
            'catatan' => 'nullable|string'
        ]);

        $penarikan = PenarikanDana::findOrFail($id);

        if ($penarikan->status !== 'pending') {
            return redirect()->back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        if ($action === 'terima') {
            $penarikan->update([
                'status' => 'disetujui',
                'catatan_admin' => $request->catatan,
                'disetujui_pada' => now(),
                'disetujui_oleh' => Auth::id()
            ]);
            
            // Notifikasi ke Petani
            \App\Models\Notifikasi::send(
                $penarikan->petani->pengguna_id,
                'penarikan_disetujui',
                'Dana Cair! 💰',
                "Pengajuan penarikan dana sebesar Rp" . number_format($penarikan->nominal, 0, ',', '.') . " telah disetujui.",
                'penarikan',
                $penarikan->id
            );

            return redirect()->back()->with('success', 'Pengajuan penarikan dana telah disetujui.');
        } else {
            $penarikan->update([
                'status' => 'ditolak',
                'catatan_admin' => $request->catatan
            ]);
            
            // Notifikasi ke Petani
            \App\Models\Notifikasi::send(
                $penarikan->petani->pengguna_id,
                'penarikan_ditolak',
                'Penarikan Ditolak ❌',
                "Maaf, pengajuan penarikan dana sebesar Rp" . number_format($penarikan->nominal, 0, ',', '.') . " ditolak. Alasan: " . ($request->catatan ?? '-'),
                'penarikan',
                $penarikan->id
            );

            return redirect()->back()->with('success', 'Pengajuan penarikan dana telah ditolak.');
        }
    }
}
