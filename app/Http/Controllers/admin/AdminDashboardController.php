<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(DashboardService $service)
    {
        return view('layouts.admin.dashboard.dashboard', $service->data());
    }
}
