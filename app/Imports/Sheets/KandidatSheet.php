<?php

namespace App\Imports\Sheets;

use App\Models\PermintaanDetail;
use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KandidatSheet implements ToCollection, WithHeadingRow
{
    protected $permintaanMap;
    protected $detailMap;
    protected $mahasiswa;

    public function __construct(&$permintaanMap, &$detailMap)
    {
        $this->permintaanMap = &$permintaanMap;
        $this->detailMap = &$detailMap;

        // 🔥 cache mahasiswa
        $this->mahasiswa = Mahasiswa::pluck('id', 'nipd')->toArray();
    }

    public function collection($rows)
    {
        foreach ($rows as $row) {

            $kode = $row['kode_permintaan'];
            $nim = $row['nim'];

            if (!$kode || !$nim) continue;

            $permintaanId = $this->permintaanMap[$kode] ?? null;
            $mahasiswaId = $this->mahasiswa[$nim] ?? null;

            if (!$permintaanId || !$mahasiswaId) continue;

            $detail = PermintaanDetail::create([
                'permintaan_id' => $permintaanId,
                'mahasiswa_id'  => $mahasiswaId,
                'status'        => $row['status_kandidat'] ?? 'pending',
            ]);

            $this->detailMap[$kode . '_' . $nim] = $detail->id;
        }
    }
}
