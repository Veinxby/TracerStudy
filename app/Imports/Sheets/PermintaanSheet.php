<?php

namespace App\Imports\Sheets;

use App\Models\Permintaan;
use App\Models\Perusahaan;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PermintaanSheet implements ToCollection, WithHeadingRow
{
    protected $map;
    protected $perusahaan;

    public function __construct(&$map)
    {
        $this->map = &$map;

        // 🔥 cache perusahaan
        $this->perusahaan = Perusahaan::pluck('id', 'nama_perusahaan')
            ->mapWithKeys(fn($id, $nama) => [strtolower(trim($nama)) => $id])
            ->toArray();
    }

    public function collection($rows)
    {
        foreach ($rows as $row) {

            if (!$row['kode_permintaan']) continue;

            $namaPerusahaan = strtolower(trim($row['perusahaan']));
            $perusahaanId = $this->perusahaan[$namaPerusahaan] ?? null;

            // kalau belum ada → buat sekali
            if (!$perusahaanId) {
                $perusahaan = Perusahaan::create([
                    'nama' => $row['perusahaan']
                ]);

                $perusahaanId = $perusahaan->id;
                $this->perusahaan[$namaPerusahaan] = $perusahaanId;
            }

            $permintaan = Permintaan::create([
                'kode_permintaan' => $row['kode_permintaan'],
                'perusahaan_id'   => $perusahaanId,
                'jenis'           => $row['jenis'],
                'posisi'          => $row['posisi'],
                'tgl_permintaan'  => Date::excelToDateTimeObject($row['tgl_permintaan'])->format('Y-m-d'),
                'kuota'           => $row['kuota'],
                'kualifikasi'     => $row['kualifikasi'],
                'catatan'         => $row['catatan'],
                'status'          => 'selesai',
            ]);

            $this->map[$row['kode_permintaan']] = $permintaan->id;
        }
    }
}
