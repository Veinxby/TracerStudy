<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::withCount('kelas')->get();
        $totalJurusan = Jurusan::count();
        $totalKelas = Kelas::count();
        $totalAngkatan = Kelas::distinct('tahun_masuk')->count('tahun_masuk');

        return view('layouts.admin.data.jurusan.index', compact('jurusan', 'totalJurusan', 'totalKelas', 'totalAngkatan'));
    }

    public function store(Request $request)
    {
        try {

            Jurusan::insert([
                'kode_jurusan' => $request->kode_jurusan,
                'nama' => $request->nama,
                'degree' => $request->degree,
                'lama_studi' => $request->lama_studi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Jurusan berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Data jurusan gagal disimpan. Silakan coba lagi atau hubungi tim IT.'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {

        Jurusan::where('id', $id)->update([
            'kode_jurusan' => $request->kode_jurusan,
            'nama' => $request->nama,
            'degree' => $request->degree,
            'lama_studi' => $request->lama_studi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data jurusan berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        Jurusan::where('id', $id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data jurusan berhasil dihapus.'
        ]);
    }
}
