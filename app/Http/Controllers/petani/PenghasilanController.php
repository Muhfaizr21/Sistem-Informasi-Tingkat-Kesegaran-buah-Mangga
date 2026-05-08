<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\PenarikanDana;
use App\Models\Petani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenghasilanController extends Controller
{
    public function index(Request $request)
    {
        $petani = Auth::user()->petani;
        
        $range = $request->query('range', 'bulan_ini');
        
        // Sales Query
        $salesQuery = DetailPesanan::where('petani_id', $petani->id)
            ->whereHas('pesanan', function($q) {
                $q->where('status', 'selesai');
            });
            
        if ($range == 'hari_ini') {
            $salesQuery->whereDate('created_at', today());
        } elseif ($range == 'minggu_ini') {
            $salesQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } else {
            $salesQuery->whereMonth('created_at', now()->month)
                       ->whereYear('created_at', now()->year);
        }

        $penjualan = $salesQuery->latest()->get();
        $totalPesanan = $penjualan->groupBy('pesanan_id')->count();
        $totalKg = $penjualan->sum('jumlah_kg');
        $totalPendapatan = $penjualan->sum('subtotal');
        
        // Total Pendapatan keseluruhan (tidak terpengaruh range untuk keperluan penarikan)
        $pendapatanKeseluruhan = DetailPesanan::where('petani_id', $petani->id)
            ->whereHas('pesanan', function($q) {
                $q->where('status', 'selesai');
            })
            ->sum('subtotal');

        // Total yang sudah ditarik (disetujui)
        $totalDitarik = PenarikanDana::where('petani_id', $petani->id)
            ->where('status', 'disetujui')
            ->sum('nominal');

        // Saldo Tersedia
        $saldoTersedia = $pendapatanKeseluruhan - $totalDitarik;

        // Riwayat Penarikan
        $riwayatPenarikan = PenarikanDana::where('petani_id', $petani->id)
            ->latest()
            ->get();

        return view('petani.laporan-penjualan', compact(
            'petani', 'pendapatanKeseluruhan', 'totalPendapatan', 'totalDitarik', 'saldoTersedia', 
            'riwayatPenarikan', 'range', 'penjualan', 'totalPesanan', 'totalKg'
        ));
    }

    public function ajukan(Request $request)
    {
        $petani = Auth::user()->petani;

        $request->validate([
            'nominal' => 'required|numeric|min:10000',
            'no_ktp' => 'required|string',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'nama_bank' => 'required|string',
            'no_rekening' => 'required|string',
            'nama_rekening' => 'required|string',
        ]);

        // Hitung saldo tersedia lagi untuk validasi
        $pendapatanKeseluruhan = DetailPesanan::where('petani_id', $petani->id)
            ->whereHas('pesanan', function($q) {
                $q->where('status', 'selesai');
            })
            ->sum('subtotal');

        $totalDitarik = PenarikanDana::where('petani_id', $petani->id)
            ->where('status', 'disetujui')
            ->sum('nominal');

        $saldoTersedia = $pendapatanKeseluruhan - $totalDitarik;

        if ($request->nominal > $saldoTersedia) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk penarikan ini.');
        }

        $fotoKtpPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoKtpPath = \App\Helpers\ImageHelper::uploadAsWebp($request->file('foto_ktp'), 'penarikan/ktp');
        }

        PenarikanDana::create([
            'petani_id' => $petani->id,
            'nominal' => $request->nominal,
            'no_ktp' => $request->no_ktp,
            'foto_ktp' => $fotoKtpPath,
            'nama_bank' => $request->nama_bank,
            'no_rekening' => $request->no_rekening,
            'nama_rekening' => $request->nama_rekening,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Pengajuan penarikan dana berhasil dikirim. Mohon tunggu verifikasi admin.');
    }
}
