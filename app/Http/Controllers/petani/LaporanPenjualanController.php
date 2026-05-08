<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Petani;
use Carbon\Carbon;

class LaporanPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $petani = Petani::firstOrCreate(['pengguna_id' => auth()->id()]);
        
        $range = $request->get('range', 'bulan_ini');
        $query = DB::table('detail_pesanan')
            ->join('pesanan', 'detail_pesanan.pesanan_id', '=', 'pesanan.id')
            ->join('listing_mangga', 'detail_pesanan.listing_id', '=', 'listing_mangga.id')
            ->where('listing_mangga.petani_id', $petani->id)
            ->whereIn('pesanan.status', ['siap_dikemas', 'dikemas', 'dikirim', 'selesai']);

        if ($range === 'hari_ini') {
            $query->whereDate('pesanan.created_at', Carbon::today());
        } elseif ($range === 'minggu_ini') {
            $query->whereBetween('pesanan.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($range === 'bulan_ini') {
            $query->whereMonth('pesanan.created_at', Carbon::now()->month)
                  ->whereYear('pesanan.created_at', Carbon::now()->year);
        }

        $penjualan = $query->select(
            'pesanan.kode_pesanan',
            'pesanan.created_at',
            'pesanan.status',
            'listing_mangga.jenis_mangga',
            'detail_pesanan.jumlah_kg',
            'detail_pesanan.harga_satuan',
            'detail_pesanan.subtotal'
        )
        ->latest('pesanan.created_at')
        ->get();

        $totalKg = $penjualan->sum('jumlah_kg');
        $totalPendapatan = $penjualan->sum('subtotal');
        $totalPesanan = $penjualan->unique('kode_pesanan')->count();

        return view('petani.laporan-penjualan', compact('penjualan', 'totalKg', 'totalPendapatan', 'totalPesanan', 'range'));
    }
}
