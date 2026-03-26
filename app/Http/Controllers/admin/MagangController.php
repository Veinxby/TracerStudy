<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MagangController extends Controller
{
    public function index()
    {
        $magang = Magang::with(['user', 'perusahaan'])
            ->orderBy('tgl_mulai', 'desc')
            ->limit(200)
            ->get();

        $totalMagang = Magang::count();

        return view('layouts.admin.aktifitas.magang', compact('magang', 'totalMagang'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required',
            'perusahaan_id' => 'required',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'posisi'        => 'required|string|max:255',
            'metode'        => 'required|in:c&p,mandiri',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Menggunakan DB Transaction agar jika salah satu gagal, semua dibatalkan
        DB::beginTransaction();

        try {
            // 1. Simpan data ke tabel magang
            Magang::create([
                'user_id'       => $request->user_id,
                'perusahaan_id' => $request->perusahaan_id,
                'tgl_mulai'     => $request->tgl_mulai,
                'tgl_selesai'   => $request->tgl_selesai,
                'posisi'        => $request->posisi,
                'sumber'        => $request->metode,
                'status'        => 'berjalan',
            ]);

            // 2. Update status_kerja di tabel mahasiswa
            $user = User::findOrFail($request->user_id);
            $user->mahasiswa()->update([
                'status_kerja' => 'magang'
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data magang berhasil ditambahkan dan status mahasiswa telah diperbarui!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'perusahaan_id' => 'required',
            'tgl_mulai'     => 'required|date',
            'tgl_selesai'   => 'required|date|after_or_equal:tgl_mulai',
            'posisi'        => 'required|string|max:255',
            'metode'        => 'required|in:c&p,mandiri',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // 2. Cari data magang yang akan diupdate
            $magang = Magang::findOrFail($id);

            // 3. Update data detail magang
            $magang->update([
                'perusahaan_id' => $request->perusahaan_id,
                'tgl_mulai'     => $request->tgl_mulai,
                'tgl_selesai'   => $request->tgl_selesai,
                'posisi'        => $request->posisi,
                'sumber'        => $request->metode,
                // 'user_id' tidak diupdate karena dari sisi UI kita disable (read-only)
            ]);

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Data magang berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
            ], 500);
        }
    }



    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $magang = Magang::findOrFail($id);

            // 1. Balikkan status mahasiswa
            $user = User::find($magang->user_id);
            if ($user && $user->mahasiswa) {
                $user->mahasiswa->update(['status_kerja' => 'available']);
            }

            // 2. Hapus data
            $magang->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data magang berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
