<?php

namespace App\Imports;

use App\Models\Interview;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Perusahaan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InterviewImport implements
    ToCollection,
    WithHeadingRow
{
    protected $report = [
        'success' => [],
        'failed'  => []
    ];

    protected $mahasiswa;
    protected $perusahaan;

    public function __construct()
    {
        // karena nipd = id user
        $this->mahasiswa = Mahasiswa::pluck('id', 'nipd')->toArray();

        // perusahaan id
        $this->perusahaan = Perusahaan::pluck('id', 'nama_perusahaan')->toArray();
    }

    public function collection(Collection $rows)
    {
        $insertData = [];

        foreach ($rows as $row) {

            $rowArray = $row->toArray();

            // Lewati jika baris kosong
            if (!array_filter($rowArray)) {
                continue;
            }

            $nipd = $rowArray['nipd'] ?? null;
            $perusahaanNama = $rowArray['perusahaan_id'] ?? null;
            $perusahaanId = $this->perusahaan[$perusahaanNama] ?? null;

            if (!$nipd) {
                continue;
            }

            // ======================
            // CEK Mahasiswa
            // ======================
            if (!isset($this->mahasiswa[$nipd])) {
                $this->report['failed'][] = [
                    'nipd' => $nipd,
                    'nama' => 'NIM tidak ditemukan'
                ];
                continue;
            }

            // ======================
            // CEK PERUSAHAAN
            // ======================
            if (!$perusahaanId || !in_array($perusahaanId, $this->perusahaan)) {
                $this->report['failed'][] = [
                    'nipd' => $nipd,
                    'nama' => $perusahaanId . 'tidak ada'
                ];
                continue;
            }

            // ======================
            // FORMAT TANGGAL
            // ======================
            $tgl = $rowArray['tgl'] ?? null;

            if (is_numeric($tgl)) {
                $tgl = Date::excelToDateTimeObject($tgl)->format('Y-m-d');
            }

            // ======================
            // VALIDASI HASIL
            // ======================
            $hasil = strtolower(trim($rowArray['hasil'] ?? ''));

            if (!in_array($hasil, ['lolos', 'gagal'])) {
                $hasil = null;
            }

            // ======================
            // VALIDASI METODE
            // ======================
            $metode = strtolower(trim($rowArray['metode'] ?? 'offline'));

            if (!in_array($metode, ['offline', 'online'])) {
                $metode = 'offline';
            }

            $mahasiswaId = $this->mahasiswa[$nipd];

            // ======================
            // PUSH KE ARRAY
            // ======================
            $insertData[] = [
                'permintaan_detail_id' => null,
                'mahasiswa_id'         => $mahasiswaId,
                'perusahaan_id'        => $perusahaanId,
                'posisi'               => $rowArray['posisi'] ?? '-',
                'tgl_interview'        => $tgl,
                'metode'               => $metode,
                'hasil'                => $hasil,
                'alasan_gagal'         => $rowArray['keterangan'] ?? null,
                'keterangan'           => $rowArray['keterangan'] ?? null,
                'created_at'           => now(),
                'updated_at'           => now(),
            ];

            $this->report['success'][] = $nipd;
        }

        // 🔥 Insert sekali saja (super cepat)
        if (!empty($insertData)) {
            Interview::insertOrIgnore($insertData);
        }
    }

    public function getReport()
    {
        return $this->report;
    }
}
