<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lahan;
use App\Models\Kecamatan;

class MappingController extends Controller
{
    public function index()
    {
        $lahan = Lahan::with(['petani.user', 'kecamatan'])->latest()->get();
        
        return view('admin.mapping', compact('lahan'));
    }
}
