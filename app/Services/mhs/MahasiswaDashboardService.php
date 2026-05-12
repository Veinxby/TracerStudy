<?php

namespace App\Services\mhs;

use App\Models\Mahasiswa;
use App\Models\Interview;
use App\Models\Penempatan;
use App\Models\Permintaan;
use App\Models\Perusahaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MahasiswaDashboardService
{
    public function data(): array
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        $penempatanAktif = Penempatan::with('perusahaan')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('status', 'aktif')
            ->latest()
            ->first();

        $riwayatMagang = Penempatan::with('perusahaan')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->latest()
            ->take(5)
            ->get();

        return [
            'nama' => $user->nama,
            'nim' => $mahasiswa->nipd,
            'ipk' => $mahasiswa->ipk,
            'email' => $user->email,
            'totalMagang' => Penempatan::where('mahasiswa_id', $mahasiswa->id)->count(),
            'totalInterview' => Interview::where('mahasiswa_id', $mahasiswa->id)->count(),
            'kode_jurusan' => $mahasiswa->kelas?->jurusan?->kode_jurusan,
            'jurusan' => $mahasiswa->kelas?->jurusan?->nama,
            'tahunMasuk' => $mahasiswa->kelas?->tahun_masuk,
            'kodeKelas' => $mahasiswa->kelas?->kode_kelas,
            'statusAkademik' => $mahasiswa->status_akademik,
            'semester' => $this->getSemester($mahasiswa),

            'statusMagang' => $penempatanAktif ? 'Aktif' : 'Available',
            'perusahaanAktif' => $penempatanAktif?->perusahaan?->nama_perusahaan,
            'posisiAktif' => $penempatanAktif?->posisi,

            'riwayatMagang' => $riwayatMagang
        ];
    }

    private function getSemester($mahasiswa)
    {
        $tahunMasuk = $mahasiswa->kelas?->tahun_masuk;

        if (!$tahunMasuk) return null;

        $now = now();
        $selisihTahun = $now->year - $tahunMasuk;

        $semester = ($now->month <= 6)
            ? ($selisihTahun * 2) + 2
            : ($selisihTahun * 2) + 1;

        return max(1, $semester);
    }
}
