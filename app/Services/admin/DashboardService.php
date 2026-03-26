<?php

namespace App\Services\Admin;

use App\Models\Mahasiswa;
use App\Models\Interview;
use App\Models\Penempatan;
use App\Models\Permintaan;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function data(): array
    {
        return [
            'adminName' => Auth::user()->nama,

            'totalMahasiswa' => Mahasiswa::count(),
            'totalPerusahaan' => Perusahaan::count(),

            'totalInterview' => Interview::count(),
            'interviewBulanIni' => Interview::whereMonth('tgl_interview', now()->month)
                ->whereYear('tgl_interview', now()->year)
                ->count(),

            'totalPenempatan' => Penempatan::count(),
            'totalMagang' => Penempatan::where('jenis', 'magang')->count(),
            'totalKerja' => Penempatan::where('jenis', 'kerja')->count(),
            'penempatanAktif' => Penempatan::where('status', 'aktif')->count(),
            'penempatanSelesai' => Penempatan::where('status', 'selesai')->count(),

            'penempatanTerbaru' => Penempatan::with(['user', 'perusahaan'])
                ->latest()
                ->take(10)
                ->get(),

            'topPerusahaan' => Perusahaan::withCount('penempatan')
                ->orderByDesc('penempatan_count')
                ->take(5)
                ->get(),
        ];
    }
}
