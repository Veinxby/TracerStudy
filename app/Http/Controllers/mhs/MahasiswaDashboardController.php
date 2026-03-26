<?php

namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MahasiswaDashboardController extends Controller
{
    public function index()
    {
        return view('layouts.mahasiswa.dashboard');
    }
}
