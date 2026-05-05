<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScanKesegaran;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    public function scanHistory()
    {
        $pembeliId = Auth::user()->pembeli?->id;
        
        $scans = ScanKesegaran::where('pembeli_id', $pembeliId)
            ->latest()
            ->paginate(12);
            
        return view('pembeli.scan.history', compact('scans'));
    }

    public function destroyScan($id)
    {
        $pembeliId = Auth::user()->pembeli?->id;
        $scan = ScanKesegaran::where('pembeli_id', $pembeliId)
            ->findOrFail($id);
            
        // Hapus file foto
        if ($scan->path_foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($scan->path_foto);
        }
        
        $scan->delete();
        
        return redirect()->back()->with('success', 'Riwayat scan berhasil dihapus.');
    }

    public function profile()
    {
        $user = Auth::user();
        $pembeli = $user->pembeli;
        
        return view('pembeli.profile', compact('user', 'pembeli'));
    }
}
