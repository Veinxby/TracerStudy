<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use App\Services\mhs\MahasiswaDashboardService;
use Illuminate\Http\Request;

class MahasiswaDashboardController extends Controller
{
    public function index(MahasiswaDashboardService $service)
    {
        return view('mahasiswa.dashboard', $service->data());
    }
    public function profile(MahasiswaDashboardService $service)
    {
        return view('mahasiswa.profile.index', $service->data());
    }
}
