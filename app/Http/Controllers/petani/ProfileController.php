<?php

namespace App\Http\Controllers\petani;

use App\Http\Controllers\Controller;
use App\Models\Petani;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Helpers\ImageHelper;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $petani = Petani::where('pengguna_id', $user->id)->first();
        
        return view('petani.profil', compact('user', 'petani'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $petani = Petani::where('pengguna_id', $user->id)->first();

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'pengalaman_tahun' => 'nullable|integer',
            'kelompok_tani' => 'nullable|string|max:100',
            'rekening_bank' => 'nullable|string|max:50',
            'nama_bank' => 'nullable|string|max:50',
            'foto_profil' => 'nullable|image|max:1024',
        ]);

        // Update User Data
        $user->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        if ($request->hasFile('foto_profil')) {
            $path = ImageHelper::uploadAsWebp($request->file('foto_profil'), 'avatars');
            $user->update(['foto_profil' => $path]);
        }

        // Update Petani Data
        if ($petani) {
            $petani->update([
                'pengalaman_tahun' => $request->pengalaman_tahun,
                'kelompok_tani' => $request->kelompok_tani,
                'rekening_bank' => $request->rekening_bank,
                'nama_bank' => $request->nama_bank,
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Kata sandi berhasil diubah!');
    }

    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'dokumen_ktp' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'dokumen_lahan' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $petani = Petani::where('pengguna_id', auth()->id())->first();

        if ($request->hasFile('dokumen_ktp')) {
            $path = ImageHelper::uploadAsWebp($request->file('dokumen_ktp'), 'dokumen');
            $petani->update(['dokumen_ktp' => $path]);
        }

        if ($request->hasFile('dokumen_lahan')) {
            $path = ImageHelper::uploadAsWebp($request->file('dokumen_lahan'), 'dokumen');
            $petani->update(['dokumen_lahan' => $path]);
        }

        return back()->with('success', 'Dokumen berhasil diunggah dan sedang diproses.');
    }
}
