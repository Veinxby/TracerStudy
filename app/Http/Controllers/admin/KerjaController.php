<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kerja;
use Illuminate\Http\Request;

class KerjaController extends Controller
{
    public function index()
    {
        $kerja = Kerja::with(['user', 'perusahaan'])
            ->orderBy('tgl_mulai', 'desc')
            ->limit(200)
            ->get();

        $totalKerja = Kerja::count();

        return view('layouts.admin.aktifitas.kerja', compact('kerja', 'totalKerja'));
    }
}
