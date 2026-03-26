<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\PenempatanImport;
use App\Models\Penempatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PenempatanController extends Controller
{
    public function index(Request $request)
    {
        $jenis  = $request->query('jenis');
        $status = $request->query('status');

        $query = Penempatan::with([
            'user',
            'perusahaan',
            'permintaanDetail.permintaan'
        ]);

        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $penempatan = $query->orderBy('tgl_mulai', 'desc')->get();


        // Statistik untuk badge tab
        $totalSemua  = Penempatan::count();
        $totalMagang = Penempatan::magang()->count();
        $totalKerja  = Penempatan::kerja()->count();
        $totalAktif  = Penempatan::aktif()->count();
        $totalSelesai  = Penempatan::selesai()->count();

        return view('layouts.admin.aktifitas.penempatan', compact(
            'penempatan',
            'jenis',
            'status',
            'totalSemua',
            'totalMagang',
            'totalKerja',
            'totalAktif',
            'totalSelesai'
        ));
    }

    public function store(Request $request)
    {
        // VALIDASI DINAMIS
        $rules = [
            'user_id'       => 'required|exists:users,id',
            'perusahaan_id' => 'required|exists:perusahaan,id',
            'jenis'         => 'required|in:magang,kerja',
            'posisi'        => 'required|string|max:255',
            'tgl_mulai'     => 'required|date',
            'sumber'        => 'required|in:c&p,mandiri',
            'keterangan'        => 'nullable',
        ];

        // Kalau magang → wajib ada tgl_selesai & durasi
        if ($request->jenis === 'magang') {
            $rules['tgl_selesai'] = 'required|date|after:tgl_mulai';
            $rules['durasi']      = 'nullable|integer|min:1|max:12';
            $rules['durasi_tipe'] = 'nullable|in:bulan,tahun';
        }

        // Kalau kerja → tipe_kontrak wajib
        if ($request->jenis === 'kerja') {
            $rules['tipe_kontrak'] = 'required|string|max:100';
            $rules['tgl_selesai']  = 'nullable|date|after:tgl_mulai';
        }

        $request->validate($rules);

        DB::beginTransaction();

        try {

            // CEK: jangan sampai mahasiswa punya penempatan aktif ganda
            $cekAktif = Penempatan::where('user_id', $request->user_id)
                ->where('status', 'aktif')
                ->exists();

            if ($cekAktif) {
                return back()->with('error', 'Mahasiswa masih memiliki penempatan aktif.');
            }

            $penempatan = Penempatan::create([
                'permintaan_id'              => null,
                'user_id'                    => $request->user_id,
                'perusahaan_id'              => $request->perusahaan_id,
                'jenis'                      => $request->jenis,
                'posisi'                     => $request->posisi,
                'tipe_kontrak'               => $request->jenis === 'kerja'
                    ? $request->tipe_kontrak
                    : null,
                'tgl_mulai'                  => $request->tgl_mulai,
                'tgl_selesai'                => $request->tgl_selesai,
                'status'                     => 'aktif',
                'sumber'                     => $request->sumber,
                'keterangan'                     => $request->keterangan,
            ]);

            // UPDATE STATUS KERJA MAHASISWA
            $mahasiswa = User::find($request->user_id)->mahasiswa;

            if ($mahasiswa) {
                $mahasiswa->update([
                    'status_kerja' => $request->jenis
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data penempatan berhasil ditambahkan dan status mahasiswa telah diperbarui!'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $penempatan = Penempatan::with('user.mahasiswa')->findOrFail($id);

        if ($penempatan->status !== 'aktif') {
            return response()->json([
                'status' => false,
                'message' => 'Status tidak dapat diubah.'
            ], 400);
        }

        $request->validate([
            'status' => 'required|in:selesai'
        ]);

        $penempatan->update([
            'status' => $request->status
        ]);

        if ($penempatan->user && $penempatan->user->mahasiswa) {
            $penempatan->user->mahasiswa->update([
                'status_kerja' => 'available'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Status berhasil diperbarui.',
            'new_status' => $penempatan->status
        ]);
    }


    public function import(Request $request)
    {
        set_time_limit(300);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            $import = new PenempatanImport();
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
