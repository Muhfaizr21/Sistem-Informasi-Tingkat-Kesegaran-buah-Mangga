<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BantuanController extends Controller
{
    public function caraPemesanan()
    {
        return view('pembeli.bantuan.cara-pemesanan');
    }

    public function tentang()
    {
        return view('pembeli.bantuan.tentang');
    }

    public function hubungiKami()
    {
        return view('pembeli.bantuan.hubungi-kami');
    }

    public function kebijakanPrivasi()
    {
        return view('pembeli.bantuan.kebijakan-privasi');
    }
}
