<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class ReviewController extends Controller
{
    public function store(Request $request, $id)
    {
        $pesanan = Pesanan::with('items')->findOrFail($id);

        // Pastikan pesanan milik pembeli ini dan sudah selesai
        if ($pesanan->pembeli_id !== Auth::user()->pembeli?->id || $pesanan->status !== 'selesai') {
            return redirect()->back()->with('error', 'Anda tidak dapat memberikan ulasan untuk pesanan ini.');
        }

        // Pastikan belum pernah memberikan ulasan
        if ($pesanan->review) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
            'foto_review.*' => 'nullable|image|max:2048', // Max 2MB per foto
        ]);

        $paths = [];
        if ($request->hasFile('foto_review')) {
            foreach ($request->file('foto_review') as $foto) {
                $paths[] = ImageHelper::uploadAsWebp($foto, 'reviews');
            }
        }

        Review::create([
            'pesanan_id' => $pesanan->id,
            'pembeli_id' => $pesanan->pembeli_id,
            'petani_id' => $pesanan->items->first()->petani_id, // Ambil petani dari item pertama
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'foto_review' => $paths,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Pastikan ulasan milik pembeli ini
        if ($review->pembeli_id !== Auth::user()->pembeli?->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah ulasan ini.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
            'foto_review.*' => 'nullable|image|max:2048',
        ]);

        $paths = $review->foto_review ?? [];
        
        // Jika ada upload foto baru, bisa pilih mau ganti semua atau tambah
        if ($request->hasFile('foto_review')) {
            // Kita asumsikan edit review mengganti foto yang ada atau menambah? 
            // Mari kita buat logic: jika upload baru, kita gunakan yang baru saja (clean start) 
            // agar tidak menumpuk sampah jika user salah pilih berkali-kali.
            $paths = []; 
            foreach ($request->file('foto_review') as $foto) {
                $paths[] = ImageHelper::uploadAsWebp($foto, 'reviews');
            }
        }

        $review->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
            'foto_review' => $paths,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Pastikan ulasan milik pembeli ini
        if ($review->pembeli_id !== Auth::user()->pembeli?->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus ulasan ini.');
        }

        // Hapus file fisik jika ada
        if ($review->foto_review) {
            foreach ($review->foto_review as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $review->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
