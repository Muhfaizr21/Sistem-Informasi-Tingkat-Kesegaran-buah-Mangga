<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanPanen;
use App\Models\LaporanTanam;
use App\Models\Pesanan;
use App\Models\Petani;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'harvest');
        
        if ($tab === 'harvest') {
            $query = LaporanPanen::with(['petani.user', 'lahan']);
            $petanis = Petani::with('user')->get();
            
            // Filters
            if ($request->filled('petani')) {
                $query->where('petani_id', $request->petani);
            }
            if ($request->filled('date_from')) {
                $query->whereDate('tanggal_panen', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('tanggal_panen', '<=', $request->date_to);
            }

            $reports = $query->latest()->paginate(20);
            return view('admin.harvest-report', compact('reports', 'tab', 'petanis'));
        }

        if ($tab === 'planting') {
            $reports = LaporanTanam::with(['petani.user', 'lahan'])->latest()->paginate(20);
            return view('admin.harvest-report', compact('reports', 'tab'));
        }

        if ($tab === 'sales') {
            $query = Pesanan::with(['pembeli.user', 'items.listing.petani.user']);
            
            // Statistics
            $totalOmset = Pesanan::where('status', 'selesai')->sum('total_bayar');
            $thisMonthOmset = Pesanan::where('status', 'selesai')
                ->whereMonth('created_at', now()->month)
                ->sum('total_bayar');
            
            $transactions = $query->latest()->paginate(20);
            return view('admin.harvest-report', compact('transactions', 'totalOmset', 'thisMonthOmset', 'tab'));
        }

        if ($tab === 'automatic') {
            return view('admin.harvest-report', compact('tab'));
        }

        return redirect()->route('admin.harvest-report', ['tab' => 'harvest']);
    }

    public function verifyHarvest(Request $request, $id)
    {
        $report = LaporanPanen::findOrFail($id);
        $report->update([
            'status' => $request->status,
            'diverifikasi_oleh' => auth()->id(),
            'diverifikasi_pada' => now(),
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Laporan panen berhasil diperbarui.');
    }

    public function verifyPlanting(Request $request, $id)
    {
        $report = LaporanTanam::findOrFail($id);
        $report->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return back()->with('success', 'Laporan tanam berhasil diperbarui.');
    }
}
