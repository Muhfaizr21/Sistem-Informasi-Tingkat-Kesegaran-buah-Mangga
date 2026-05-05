<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use App\Models\AlamatPengiriman;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $pembeli = Auth::user()->pembeli;
        $alamats = AlamatPengiriman::with('kecamatan')
            ->where('pembeli_id', $pembeli->id)
            ->latest()
            ->get();
        $kecamatans = Kecamatan::orderBy('nama')->get();

        return view('pembeli.alamat.index', compact('alamats', 'kecamatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:50',
            'nama_penerima' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
        ]);

        $pembeli = Auth::user()->pembeli;

        // If this is the first address, make it primary
        $isFirst = AlamatPengiriman::where('pembeli_id', $pembeli->id)->count() === 0;

        AlamatPengiriman::create([
            'pembeli_id' => $pembeli->id,
            'label' => $request->label,
            'nama_penerima' => $request->nama_penerima,
            'no_telepon' => $request->no_telepon,
            'alamat_lengkap' => $request->alamat_lengkap,
            'kecamatan_id' => $request->kecamatan_id,
            'kota' => $request->kota,
            'kode_pos' => $request->kode_pos,
            'utama' => $isFirst || $request->has('utama'),
        ]);

        if ($request->has('utama')) {
            $this->resetUtama($pembeli->id);
        }

        return redirect()->back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $alamat = AlamatPengiriman::findOrFail($id);
        
        $request->validate([
            'label' => 'required|string|max:50',
            'nama_penerima' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string',
            'kecamatan_id' => 'required|exists:kecamatan,id',
            'kota' => 'required|string|max:100',
            'kode_pos' => 'required|string|max:10',
        ]);

        $alamat->update($request->all());

        if ($request->has('utama')) {
            $this->resetUtama($alamat->pembeli_id, $alamat->id);
        }

        return redirect()->back()->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $alamat = AlamatPengiriman::findOrFail($id);
        $alamat->delete();

        return redirect()->back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function setUtama($id)
    {
        $alamat = AlamatPengiriman::findOrFail($id);
        $this->resetUtama($alamat->pembeli_id, $alamat->id);

        return redirect()->back()->with('success', 'Alamat utama berhasil diubah.');
    }

    private function resetUtama($pembeliId, $keepId = null)
    {
        AlamatPengiriman::where('pembeli_id', $pembeliId)->update(['utama' => false]);
        if ($keepId) {
            AlamatPengiriman::where('id', $keepId)->update(['utama' => true]);
        }
    }
}
