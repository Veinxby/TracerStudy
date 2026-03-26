<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\MahasiswaImport;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DataMhsController extends Controller
{
    public function index(Request $request)
    {
        $jurusan  = $request->jurusan;
        $angkatan = $request->angkatan;

        $mahasiswa = Mahasiswa::with(['user', 'kelas.jurusan'])

            ->when($jurusan, function ($q) use ($jurusan) {
                $q->whereHas('kelas.jurusan', function ($q2) use ($jurusan) {
                    $q2->where('kode_jurusan', $jurusan);
                });
            })

            ->when($angkatan, function ($q) use ($angkatan) {
                $q->whereHas('kelas', function ($q2) use ($angkatan) {
                    $q2->where('tahun_masuk', $angkatan);
                });
            })

            ->orderBy('nipd')
            ->get();

        $jurusanList = Jurusan::orderBy('kode_jurusan')->get();

        $angkatanList = Kelas::select('tahun_masuk')
            ->distinct()
            ->orderBy('tahun_masuk', 'desc')
            ->pluck('tahun_masuk');

        return view('layouts.admin.data.dataMhs', compact(
            'mahasiswa',
            'jurusanList',
            'angkatanList'
        ));
    }

    public function searchMahasiswa(Request $request)
    {
        $search = $request->q;

        $data = User::where('role', 'mhs')
            ->whereHas('mahasiswa', function ($query) {
                $query->where('status_akademik', 'aktif')
                    ->where('status_kerja', 'available');
            })
            ->with(['mahasiswa.kelas'])
            ->where('nama', 'like', "%$search%")
            ->limit(10)
            ->get()
            ->map(function ($user) {
                $mhs = $user->mahasiswa;
                $kelas = $mhs->kelas ?? null;

                return [
                    'id'         => $mhs->id,
                    'userId'     => $user->id,
                    'text'       => $user->nama, // Keperluan internal Select2
                    'nama'       => $user->nama,
                    'kode_kelas' => $kelas ? ($kelas->jurusan_id . $kelas->kode_kelas) : '-',
                    'tahun'      => $kelas->tahun_masuk ?? '-'
                ];
            });

        return response()->json($data);
    }

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with(['user', 'kelas'])->findOrFail($id);
        $kelas = Kelas::select('id', 'jurusan_id', 'kode_kelas', 'tahun_masuk')
            ->orderBy('tahun_masuk', 'desc')
            ->get();

        return response()->json([
            'mahasiswa' => $mahasiswa,
            'kelas' => $kelas
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'      => 'required|string',
            'email'     => 'sometimes|nullable|email',
            'jk'        => 'required|in:L,P',
            'no_hp'     => 'nullable|string',
            'domisili'  => 'nullable|string',
            'kelas_id'  => 'required|exists:kelas,id',
        ], [
            'nama.required'     => 'Nama wajib diisi',
            'jk.required'       => 'Jenis kelamin wajib dipilih',
            'jk.in'             => 'Jenis kelamin tidak valid',
            'email.email'       => 'Format email tidak valid',
            'kelas_id.required' => 'Kelas wajib dipilih',
            'kelas_id.exists'   => 'Kelas tidak valid',
        ]);

        $mahasiswa = Mahasiswa::with('user')->findOrFail($id);

        // update tabel user
        $mahasiswa->user->update([
            'nama'  => $request->nama,
            'email' => $request->email,
        ]);

        // update tabel mahasiswa
        $mahasiswa->update([
            'jk'        => $request->jk,
            'no_hp'     => $request->no_hp,
            'domisili'  => $request->domisili,
            'kelas_id'  => $request->kelas_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil diperbarui',
        ]);
    }




    // Proses import Excel
    public function import(Request $request)
    {
        try {
            $import = new MahasiswaImport();

            Excel::import($import, $request->file('file'));

            $result = $import->getReport();

            return redirect()->back()->with([
                'import_success' => count($result['success']),
                'import_failed' => count($result['failed']),
                'failed_list' => $result['failed']
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        DB::table('mahasiswa')
            ->where('id', $id)
            ->update(['status_akademik' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function detail($nipd)
    {

        $mahasiswa = Mahasiswa::with([
            'interviews.perusahaan',
            'penempatan.perusahaan'
        ])->where('nipd', $nipd)->firstOrFail();

        // Kirim data ke view
        return view('layouts.admin.data.detailMhs', [
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
