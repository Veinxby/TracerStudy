<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\InterviewImport;
use App\Models\Interview;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InterviewController extends Controller
{
    public function index()
    {
        $interviews = Interview::with(['mahasiswa', 'perusahaan', 'permintaanDetail.permintaan'])
            ->orderBy('tgl_interview', 'desc')
            ->limit(200)
            ->get();

        $totalInterview = Interview::count();

        return view('layouts.admin.aktifitas.interview', compact('interviews', 'totalInterview'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required',
    //         'perusahaan_id' => 'required',
    //         'tgl_interview' => 'required',
    //     ]);

    //     Interview::create([
    //         'user_id' => $request->user_id,
    //         'perusahaan_id' => $request->perusahaan_id,
    //         'tgl_interview' => $request->tgl_interview,
    //         'posisi' => $request->posisi,
    //         'metode' => $request->metode,
    //         'hasil' => $request->hasil,
    //         'keterangan' => $request->keterangan,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data interview berhasil ditambahkan'
    //     ]);
    // }


    public function import(Request $request)
    {
        // Tingkatkan limit waktu untuk proses data besar
        set_time_limit(300); // 5 Menit

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $import = new InterviewImport();
            Excel::import($import, $request->file('file'));

            $result = $import->getReport();

            return redirect()->back()->with([
                'import_success' => count($result['success']),
                'import_failed'  => count($result['failed']),
                'failed_list'    => $result['failed']
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}
