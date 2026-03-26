<?php

namespace App\Http\Controllers\bm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchManagerDashboardController extends Controller
{
    public function index()
    {
        return view('layouts.bm.dashboard');
    }
}
