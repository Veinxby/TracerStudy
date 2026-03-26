<?php

namespace App\Imports;

use App\Models\Perusahaan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PerusahaanImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected $report = [
        'success' => [],
        'failed'  => []
    ];

    // penampung untuk cegah duplikat dalam 1 file
    protected $sudahDipakai = [];

    /**
     * Bersihkan string
     */
    private function clean($text)
    {
        $text = trim($text);                     // hapus spasi depan belakang
        $text = preg_replace('/\s+/', ' ', $text); // hapus spasi dobel
        return strtoupper($text);                // samakan huruf
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // kalau kosong semua → skip
            if (!array_filter($row->toArray())) {
                continue;
            }

            $namaAsli = $row['nama_perusahaan'] ?? null;

            // ======================
            // WAJIB ADA NAMA
            // ======================
            if (!$namaAsli) {
                $this->report['failed'][] = [
                    'nama_perusahaan' => $row['nama_perusahaan'] ?? '-',
                    'pesan' => 'Nama perusahaan wajib diisi'
                ];
                continue;
            }

            $namaCek = $this->clean($namaAsli);

            // ======================
            // CEK DUPLIKAT
            // ======================
            if (in_array($namaCek, $this->sudahDipakai)) {
                $this->report['failed'][] = [
                    'nama_perusahaan' => $row['nama_perusahaan'] ?? '-',
                    'pesan' => 'Duplikat di file excel'
                ];
                continue;
            }

            try {
                Perusahaan::create([
                    'nama_perusahaan' => trim($namaAsli),
                    'bidang_usaha'    => trim($row['bidang_usaha'] ?? '-') ?: '-',
                    'email'           => trim($row['email'] ?? '-') ?: '-',
                    'no_telepon'      => trim($row['no_hp'] ?? '-') ?: '-',
                    'alamat'          => trim($row['alamat'] ?? '-') ?: '-',
                    'kota'            => trim($row['kota'] ?? '-') ?: '-',
                    'provinsi'        => trim($row['provinsi'] ?? '-') ?: '-',
                ]);

                $this->report['success'][] = $namaAsli;

                // masukkan supaya berikutnya dianggap duplicate
                $this->sudahDipakai[] = $namaCek;
            } catch (\Throwable $e) {
                $this->report['failed'][] = [
                    'nama_perusahaan' => $row['nama_perusahaan'] ?? '-',
                    'pesan' => $e->getMessage()
                ];
            }
        }
    }

    public function getReport()
    {
        return $this->report;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
