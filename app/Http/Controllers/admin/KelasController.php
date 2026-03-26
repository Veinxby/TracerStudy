<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function index($id)
    {
        $jurusan = Jurusan::where('kode_jurusan', $id)->firstOrFail();

        $kelas = Kelas::where('jurusan_id', $jurusan->id)
            ->withCount('mahasiswa')
            ->orderBy('tahun_masuk', 'DESC')
            ->get();

        $totalKelas = $kelas->count();

        $totalAngkatan = Kelas::where('jurusan_id', $jurusan->id)
            ->distinct('tahun_masuk')
            ->count('tahun_masuk');

        return view('layouts.admin.data.jurusan.kelas', compact(
            'jurusan',
            'kelas',
            'totalKelas',
            'totalAngkatan'
        ));
    }

    public function byKelas($kode, $kelasId)
    {
        $jurusan = Jurusan::where('kode_jurusan', $kode)->firstOrFail();

        $kelas = Kelas::with('jurusan')
            ->where('id', $kelasId)
            ->where('jurusan_id', $jurusan->id)
            ->firstOrFail();

        $mahasiswa = Mahasiswa::with('user')
            ->where('kelas_id', $kelas->id)
            ->orderBy('nipd')
            ->get();

        // =============================
        // Statistik kelas
        // =============================

        $totalMahasiswa = $mahasiswa->count();

        $ipkRata = $mahasiswa->avg('ipk');

        $jumlahAktif = $mahasiswa->where('status_akademik', 'aktif')->count();

        $jumlahLulus = $mahasiswa->where('status_akademik', 'lulus')->count();

        return view('layouts.admin.data.jurusan.mahasiswaByKelas', compact(
            'jurusan',
            'kelas',
            'mahasiswa',
            'totalMahasiswa',
            'ipkRata',
            'jumlahAktif',
            'jumlahLulus'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required',
            'kode_kelas' => [
                'required',
                'numeric',
                Rule::unique('kelas')->where(function ($query) use ($request) {
                    return $query->where('jurusan_id', $request->jurusan_id);
                }),
            ],
            'tahun_masuk' => 'required|numeric'
        ], [
            'kode_kelas.unique' => 'Kode kelas sudah digunakan pada jurusan ini.'
        ]);

        Kelas::create([
            'jurusan_id' => $request->jurusan_id,
            'kode_kelas' => $request->kode_kelas,
            'tahun_masuk' => $request->tahun_masuk
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kelas berhasil ditambahkan'
        ]);
    }


    public function update(Request $request, $kode, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $request->validate([
            'kode_kelas' => 'required|numeric',
            'tahun_masuk' => 'required|numeric'
        ]);

        $exists = Kelas::where('jurusan_id', $kelas->jurusan_id)
            ->where('kode_kelas', $request->kode_kelas)
            ->where('id', '!=', $kelas->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Kode kelas ini sudah digunakan pada jurusan tersebut.'
            ], 422);
        }

        $kelas->update([
            'kode_kelas' => $request->kode_kelas,
            'tahun_masuk' => $request->tahun_masuk
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($kode, $id)
    {
        $kelas = Kelas::findOrFail($id);

        if ($kelas->mahasiswa()->count() > 0) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Kelas ini masih memiliki mahasiswa. Pindahkan mahasiswa terlebih dahulu sebelum menghapus kelas.'
            ]);
        }

        $kelas->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Kelas berhasil dihapus.'
        ]);
    }
}
