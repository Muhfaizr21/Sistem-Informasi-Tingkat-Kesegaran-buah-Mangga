<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Petani;
use App\Models\Pembeli;
use App\Models\Lahan;
use App\Models\LaporanPanen;
use App\Models\ScanKesegaran;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // User Statistics
        $totalPetani = Petani::count();
        $totalPembeli = Pembeli::count();
        
        // Land Statistics
        $totalLahan = Lahan::count();
        $totalHektar = Lahan::sum('luas_hektar');
        
        // Harvest Statistics
        $totalPanenKg = LaporanPanen::where('status', 'verified')->sum('jumlah_kg');
        $totalPanenTon = $totalPanenKg / 1000;
        
        // Quality Statistics (AI Scan)
        $avgQuality = ScanKesegaran::avg('skor_kesegaran') ?? 0;
        $qualityGrade = 'N/A';
        if ($avgQuality >= 85) $qualityGrade = 'Grade A';
        elseif ($avgQuality >= 75) $qualityGrade = 'Grade B';
        elseif ($avgQuality >= 60) $qualityGrade = 'Grade C';
        elseif ($avgQuality > 0) $qualityGrade = 'Grade D';

        // Transaction Statistics
        $totalTransaksi = Pesanan::whereIn('status', ['dikonfirmasi', 'dikirim', 'selesai'])->sum('total_bayar');
        
        // Verification Queue
        $pendingPetani = Petani::where('status_verifikasi', 'pending')->with('user')->limit(5)->get();
        $pendingPanen = LaporanPanen::where('status', 'submitted')->with(['petani.user', 'lahan'])->limit(5)->get();

        // Real Growth metrics
        $lastMonth = now()->subMonth();
        
        $newPetani = Petani::where('created_at', '>=', $lastMonth)->count();
        $newPembeli = Pembeli::where('created_at', '>=', $lastMonth)->count();
        $newPanen = LaporanPanen::where('created_at', '>=', $lastMonth)->count();
        
        $growth = [
            'petani' => $newPetani,
            'pembeli' => $newPembeli,
            'panen' => $newPanen,
            'transaksi' => $totalTransaksi > 1000000 ? 'Tinggi' : 'Normal'
        ];

        // Production Trend (Last 6 Months)
        $months = [];
        $harvestData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->translatedFormat('M');
            
            $production = LaporanPanen::whereIn('status', ['verified', 'approved'])
                ->whereYear('tanggal_panen', $date->year)
                ->whereMonth('tanggal_panen', $date->month)
                ->sum('jumlah_kg');
                
            $harvestData[] = $production > 0 ? $production / 1000 : 0; 
        }

        return view('admin.dashboard', compact(
            'totalPetani', 'totalPembeli', 'totalLahan', 'totalHektar', 
            'totalPanenTon', 'avgQuality', 'qualityGrade', 'totalTransaksi',
            'pendingPetani', 'pendingPanen', 'growth', 'months', 'harvestData'
        ));
    }

    public function qualityMonitor(Request $request)
    {
        $tab = $request->get('tab', 'review');
        
        // Base query for scans
        $query = ScanKesegaran::with(['pembeli.user', 'petani.user', 'lahan.kecamatan']);
        
        // Tab-specific logic
        if ($tab === 'review') {
            $scans = (clone $query)->latest()->paginate(20);
            
            // Trend Analysis (Last 7 Days)
            $trends = ScanKesegaran::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('AVG(skor_kesegaran) as avg_score'),
                DB::raw('COUNT(*) as total_scans')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

            // Anomaly Detection (Simplified: scores that are very different from neighbors or extreme outliers)
            $anomalies = (clone $query)->where('is_anomaly', true)
                ->orWhere('skor_kepercayaan', '<', 60)
                ->latest()
                ->limit(10)
                ->get();

            $avgQuality = ScanKesegaran::avg('skor_kesegaran') ?? 0;
            $totalScans = ScanKesegaran::count();
            $optimalCount = ScanKesegaran::where('skor_kesegaran', '>=', 80)->count();
            
            $growth = 0;
            $lastMonth = ScanKesegaran::where('created_at', '>=', now()->subMonth())->count();
            $prevMonth = ScanKesegaran::whereBetween('created_at', [now()->subMonths(2), now()->subMonth()])->count();
            if ($prevMonth > 0) {
                $growth = (($lastMonth - $prevMonth) / $prevMonth) * 100;
            }

            return view('admin.quality-monitor', compact('scans', 'avgQuality', 'totalScans', 'optimalCount', 'growth', 'trends', 'anomalies', 'tab'));
        } 
        
        if ($tab === 'verification') {
            $pendingScans = (clone $query)->where('status_verifikasi', 'pending')->latest()->paginate(20);
            return view('admin.quality-monitor', compact('pendingScans', 'tab'));
        }

        if ($tab === 'calibration') {
            $accuracyTrend = [85, 87, 86, 89, 91, 90, 92]; // Mock accuracy trend
            $totalTrainingData = ScanKesegaran::where('status_verifikasi', 'verified')->count();
            return view('admin.quality-monitor', compact('accuracyTrend', 'totalTrainingData', 'tab'));
        }

        if ($tab === 'report') {
            $perPetani = DB::table('scan_kesegaran')
                ->join('petani', 'scan_kesegaran.petani_id', '=', 'petani.id')
                ->join('pengguna', 'petani.pengguna_id', '=', 'pengguna.id')
                ->select('pengguna.nama', DB::raw('AVG(skor_kesegaran) as avg_score'), DB::raw('COUNT(*) as total'))
                ->groupBy('pengguna.nama')
                ->orderByDesc('avg_score')
                ->get();

            $perJenis = ScanKesegaran::select('jenis_mangga', DB::raw('AVG(skor_kesegaran) as avg_score'), DB::raw('COUNT(*) as total'))
                ->groupBy('jenis_mangga')
                ->orderByDesc('avg_score')
                ->get();

            return view('admin.quality-monitor', compact('perPetani', 'perJenis', 'tab'));
        }

        return redirect()->route('admin.quality-monitor', ['tab' => 'review']);
    }

    public function verifyScan(Request $request, $id)
    {
        $scan = ScanKesegaran::findOrFail($id);
        $scan->update([
            'status_verifikasi' => $request->status, // verified or rejected
            'skor_manual' => $request->skor_manual,
            'catatan_admin' => $request->catatan,
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
        ]);

        return back()->with('success', 'Hasil scan berhasil diverifikasi.');
    }

    public function markAnomaly($id)
    {
        $scan = ScanKesegaran::findOrFail($id);
        $scan->update(['is_anomaly' => !$scan->is_anomaly]);
        return back()->with('success', 'Status anomali diperbarui.');
    }

    public function pesanan(Request $request)
    {
        $status = $request->status;
        $query = Pesanan::with(['pembeli.user', 'items.listing.petani.user']);

        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        $pesanans = $query->latest()->paginate(10);

        // Stats for summary cards
        $stats = [
            'total' => Pesanan::count(),
            'pending' => Pesanan::whereIn('status', ['menunggu_bayar', 'menunggu_verifikasi', 'menunggu_verifikasi_selesai'])->count(),
            'processed' => Pesanan::whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim'])->count(),
            'completed' => Pesanan::where('status', 'selesai')->count(),
            'revenue' => Pesanan::where('status', 'selesai')->sum('total_bayar')
        ];

        return view('admin.pesanan.index', compact('pesanans', 'stats', 'status'));
    }

    public function verifikasiPembayaran(Request $request)
    {
        $type = $request->get('type', 'pembayaran');
        
        $query = Pesanan::with(['pembeli.user', 'items.listing']);
        
        if ($type === 'penerimaan') {
            $query->where('status', 'menunggu_verifikasi_selesai');
        } else {
            $query->where('status', 'menunggu_verifikasi');
        }

        $pesanans = $query->latest()->get();
        return view('admin.pesanan.verifikasi', compact('pesanans', 'type'));
    }

    public function konfirmasiPembayaran(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
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

        // Logic to send notification
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
        $pesanan = Pesanan::findOrFail($id);
        
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

    }

    public function konfirmasiSelesai(Request $request, $id)
    {
        $pesanan = Pesanan::with('pembeli')->findOrFail($id);
        
        if ($pesanan->status !== 'menunggu_verifikasi_selesai') {
            return redirect()->back()->with('error', 'Pesanan tidak dalam status menunggu verifikasi penyelesaian.');
        }

        $pesanan->update([
            'status' => 'selesai',
            'selesai_pada' => now(),
            'catatan_admin' => $request->catatan
        ]);

        // Update Loyalty Poin
        $this->updateLoyalty($pesanan);

        // Notifikasi ke Pembeli
        \App\Models\Notifikasi::send(
            $pesanan->pembeli->pengguna_id,
            'pesanan_selesai_admin',
            'Pesanan Selesai! 🏁',
            "Pesanan {$pesanan->kode_pesanan} telah diverifikasi admin dan dinyatakan selesai. Terima kasih!",
            'pesanan',
            $pesanan->id
        );

        // Notifikasi ke Petani (Dana diteruskan)
        $firstItem = $pesanan->items()->first();
        if ($firstItem && $firstItem->listing && $firstItem->listing->petani) {
            \App\Models\Notifikasi::send(
                $firstItem->listing->petani->pengguna_id,
                'dana_diteruskan',
                'Dana Diteruskan! 💸',
                "Pesanan {$pesanan->kode_pesanan} telah selesai diverifikasi admin. Dana hasil penjualan telah diteruskan ke saldo/rekening Anda.",
                'pesanan',
                $pesanan->id
            );
        }

        return redirect()->back()->with('success', 'Pesanan berhasil diselesaikan dan dana telah diteruskan ke petani.');
    }

    private function updateLoyalty($pesanan)
    {
        $pembeli = Pembeli::find($pesanan->pembeli_id);
        if (!$pembeli) return;
        
        // 1 poin per Rp 10.000 belanja
        $poinBaru = floor($pesanan->total_harga / 10000);
        $pembeli->poin_loyalitas += $poinBaru;
        
        if ($pembeli->poin_loyalitas > 2000) {
            $pembeli->tier_member = 'platinum';
        } elseif ($pembeli->poin_loyalitas > 500) {
            $pembeli->tier_member = 'gold';
        } else {
            $pembeli->tier_member = 'silver';
        }

        $pembeli->save();
    }
}
