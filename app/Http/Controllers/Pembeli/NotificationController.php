<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notifikasi::where('pengguna_id', Auth::id())
            ->latest()
            ->paginate(20);
            
        return view('pembeli.notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notifikasi::where('pengguna_id', Auth::id())
            ->findOrFail($id);
            
        $notification->update(['sudah_dibaca' => true]);
        
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);
            
        return redirect()->back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }
}
