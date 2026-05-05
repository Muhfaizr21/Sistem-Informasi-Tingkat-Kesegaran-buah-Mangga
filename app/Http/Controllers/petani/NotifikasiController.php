<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function markAsRead($id)
    {
        $notif = Notifikasi::where('pengguna_id', Auth::id())->findOrFail($id);
        $notif->update(['sudah_dibaca' => true]);

        return back()->with('success', 'Notifikasi ditandai telah dibaca.');
    }

    public function destroy($id)
    {
        $notif = Notifikasi::where('pengguna_id', Auth::id())->findOrFail($id);
        $notif->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function markAllAsRead()
    {
        Notifikasi::where('pengguna_id', Auth::id())
            ->where('sudah_dibaca', false)
            ->update(['sudah_dibaca' => true]);

        return back()->with('success', 'Semua notifikasi telah dibaca.');
    }
}
