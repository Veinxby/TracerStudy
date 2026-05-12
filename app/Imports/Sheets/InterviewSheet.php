<?php

namespace App\Imports\Sheets;

use App\Models\Interview;
use App\Models\Penempatan;
use App\Models\Mahasiswa;
use App\Models\Permintaan;
use Exception;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class InterviewSheet implements ToCollection, WithHeadingRow
{
    protected $permintaanMap;
    protected $detailMap;
    protected $mahasiswa;
    protected $permintaan;

    public function __construct(&$permintaanMap, &$detailMap)
    {
        $this->permintaanMap = &$permintaanMap;
        $this->detailMap = &$detailMap;

        // 🔥 cache mahasiswa
        $this->mahasiswa = Mahasiswa::pluck('id', 'nipd')->toArray();

        // 🔥 cache permintaan
        $this->permintaan = Permintaan::all()->keyBy('id');
    }

    public function collection($rows)
    {
        foreach ($rows as $index => $row) {

            $kode = trim($row['kode_permintaan']);
            $nim  = trim((string) $row['nim']);
            $hasil = strtolower(trim($row['hasil']));

            $key = $kode . '_' . $nim;

            $detailId = $this->detailMap[$key] ?? null;
            $permintaanId = $this->permintaanMap[$kode] ?? null;
            $mahasiswaId = $this->mahasiswa[$nim] ?? null;

            // ❌ VALIDASI RELASI
            if (!$detailId) {
                throw new Exception("Baris " . ($index + 2) . ": Detail tidak ditemukan ($kode - $nim)");
            }

            if (!$permintaanId) {
                throw new Exception("Baris " . ($index + 2) . ": Permintaan tidak ditemukan ($kode)");
            }

            if (!$mahasiswaId) {
                throw new Exception("Baris " . ($index + 2) . ": Mahasiswa tidak ditemukan ($nim)");
            }

            $permintaan = Permintaan::find($permintaanId);

            if (!$permintaan) {
                throw new Exception("Baris " . ($index + 2) . ": Permintaan tidak ditemukan di DB ($kode)");
            }

            // ❌ VALIDASI FIELD WAJIB
            if (!$row['tgl_interview']) {
                throw new Exception("Baris " . ($index + 2) . ": Tanggal interview kosong");
            }

            if (!$row['metode']) {
                throw new Exception("Baris " . ($index + 2) . ": Metode interview kosong");
            }

            if (!$hasil) {
                throw new Exception("Baris " . ($index + 2) . ": Hasil interview kosong");
            }

            // 🔥 CONVERT DATE
            $tglInterview = is_numeric($row['tgl_interview'])
                ? Date::excelToDateTimeObject($row['tgl_interview'])->format('Y-m-d')
                : date('Y-m-d', strtotime($row['tgl_interview']));

            // ✅ INSERT INTERVIEW
            Interview::create([
                'permintaan_detail_id' => $detailId,
                'mahasiswa_id'         => $mahasiswaId,
                'perusahaan_id'        => $permintaan->perusahaan_id,
                'posisi'               => $permintaan->posisi,
                'tgl_interview'        => $tglInterview,
                'metode'               => strtolower(trim($row['metode'])),
                'hasil'                => $hasil,
                'alasan_gagal'         => $row['alasan_gagal'] ?? null,
                'keterangan'           => $row['keterangan'] ?? null,
            ]);

            // 🔥 AUTO PENEMPATAN
            if ($hasil === 'lolos') {

                $tglMulai = $row['tgl_mulai']
                    ? (is_numeric($row['tgl_mulai'])
                        ? Date::excelToDateTimeObject($row['tgl_mulai'])->format('Y-m-d')
                        : date('Y-m-d', strtotime($row['tgl_mulai'])))
                    : null;

                $tglSelesai = $row['tgl_selesai']
                    ? (is_numeric($row['tgl_selesai'])
                        ? Date::excelToDateTimeObject($row['tgl_selesai'])->format('Y-m-d')
                        : date('Y-m-d', strtotime($row['tgl_selesai'])))
                    : null;

                Penempatan::create([
                    'permintaan_detail_id' => $detailId,
                    'mahasiswa_id'         => $mahasiswaId,
                    'perusahaan_id'        => $permintaan->perusahaan_id,
                    'jenis'                => $permintaan->jenis,
                    'posisi'               => $permintaan->posisi,
                    'tipe_kontrak'         => $row['tipe_kontrak'] ?? null,
                    'tgl_mulai'            => $tglMulai,
                    'tgl_selesai'          => $tglSelesai,
                    'status'               => 'selesai',
                    'sumber'               => $row['sumber'] ?? null,
                    'keterangan'           => $row['keterangan'] ?? null,
                ]);
            }
        }
    }
}
