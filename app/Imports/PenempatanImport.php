<?php

namespace App\Imports;

use App\Models\Penempatan;
use App\Models\User;
use App\Models\Perusahaan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class PenempatanImport implements
    ToCollection,
    WithHeadingRow,
    WithCalculatedFormulas
{
    protected $report = [
        'success' => [],
        'failed'  => []
    ];

    protected $users;
    protected $perusahaan;

    public function __construct()
    {
        $this->users = User::pluck('id')->toArray();
        $this->perusahaan = Perusahaan::pluck('id')->toArray();
    }

    public function collection(Collection $rows)
    {
        $insertData = [];

        foreach ($rows as $row) {

            $rowArray = $row->toArray();

            if (!array_filter($rowArray)) {
                continue;
            }

            $nipd = $rowArray['nipd'] ?? null;
            $perusahaanId = $rowArray['perusahaan_id'] ?? null;

            if (!$nipd) {
                continue;
            }

            // ======================
            // CEK USER
            // ======================
            if (!in_array($nipd, $this->users)) {
                $this->report['failed'][] = [
                    'nipd' => $nipd,
                    'nama' => 'User tidak ditemukan'
                ];
                continue;
            }

            // ======================
            // CEK PERUSAHAAN
            // ======================
            if (!$perusahaanId || !in_array($perusahaanId, $this->perusahaan)) {
                $this->report['failed'][] = [
                    'nipd' => $nipd,
                    'nama' => 'Perusahaan tidak ditemukan'
                ];
                continue;
            }

            // ======================
            // FORMAT TANGGAL MULAI
            // ======================
            $tglMulai = $rowArray['tgl_mulai'] ?? null;

            if (is_numeric($tglMulai)) {
                $tglMulai = Date::excelToDateTimeObject($tglMulai)->format('Y-m-d');
            }

            // ======================
            // FORMAT TANGGAL SELESAI
            // ======================
            $tglSelesai = $rowArray['tgl_selesai'] ?? null;

            if (is_numeric($tglSelesai)) {
                $tglSelesai = Date::excelToDateTimeObject($tglSelesai)->format('Y-m-d');
            }

            // ======================
            // VALIDASI STATUS
            // ======================
            $status = strtolower(trim($rowArray['status'] ?? 'aktif'));

            if (!in_array($status, ['aktif', 'selesai', 'batal'])) {
                $status = 'aktif';
            }

            // ======================
            // PUSH DATA
            // ======================
            $insertData[] = [
                'permintaan_detail_id' => null,
                'user_id'              => $nipd,
                'perusahaan_id'        => $perusahaanId,
                'jenis'                => $rowArray['jenis'] ?? null,
                'posisi'               => $rowArray['posisi'] ?? '-',
                'tipe_kontrak'         => $rowArray['tipe_kontrak'] ?? null,
                'tgl_mulai'            => $tglMulai,
                'tgl_selesai'          => $tglSelesai ?? null,
                'status'               => $status,
                'sumber'               => $rowArray['sumber'] ?? null,
                'keterangan'           => $rowArray['keterangan'] ?? null,
                'created_at'           => now(),
                'updated_at'           => now(),
            ];

            $this->report['success'][] = $nipd;
        }

        if (!empty($insertData)) {
            Penempatan::insertOrIgnore($insertData);
        }
    }

    public function getReport()
    {
        return $this->report;
    }
}
