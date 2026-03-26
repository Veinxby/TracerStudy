<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MahasiswaImport implements ToCollection, WithHeadingRow
{
    protected $report = [
        'success' => [],
        'failed' => []
    ];

    public function collection(Collection $rows)
    {
        $nipds = $rows->pluck('nipd')->toArray();

        $existingNipd = Mahasiswa::whereIn('nipd', $nipds)
            ->pluck('nipd')
            ->toArray();

        $existingNipd = array_flip($existingNipd);

        $kelasCache = [];
        $dataUsers = [];
        $dataMahasiswa = [];
        $validNipds = [];
        $passwordCache = [];


        try {

            DB::beginTransaction();

            foreach ($rows as $row) {

                $row = $row->toArray();

                $nipd = (string)$row['nipd'];
                $nama = $row['nama'];

                if (isset($existingNipd[$nipd])) {

                    $this->report['failed'][] = [
                        'nipd' => $nipd,
                        'nama' => $nama,
                        'error' => 'Sudah Terdaftar'
                    ];

                    continue;
                }

                $passwordAwal = substr($nipd, 0, 7);

                if (!isset($passwordCache[$passwordAwal])) {
                    $passwordCache[$passwordAwal] = Hash::make($passwordAwal);
                }

                $password = $passwordCache[$passwordAwal];

                $ipk = isset($row['ipk'])
                    ? str_replace(',', '.', $row['ipk'])
                    : 0;


                $dataUsers[] = [
                    'username' => $nipd,
                    'nama' => $nama,
                    'email' => $row['email'] ?? null,
                    'password' => $password,
                    'role' => 'mhs',
                    'is_active' => '1',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $validNipds[] = $nipd;

                $this->report['success'][] = [
                    'nipd' => $nipd,
                    'nama' => $nama
                ];
            }

            // insert user batch
            User::insert($dataUsers);

            // ambil id user sekali saja
            $users = User::whereIn('username', $validNipds)
                ->pluck('id', 'username');


            foreach ($rows as $row) {

                $row = $row->toArray();

                $nipd = (string)$row['nipd'];

                if (!isset($users[$nipd])) {
                    continue;
                }

                $key = $row['jurusan'] . '-' . $row['kode_kelas'] . '-' . $row['tahun_masuk'];

                if (!isset($kelasCache[$key])) {

                    $kelasCache[$key] = Kelas::firstOrCreate([
                        'jurusan_id' => $row['jurusan'],
                        'kode_kelas' => $row['kode_kelas'],
                        'tahun_masuk' => $row['tahun_masuk']
                    ]);
                }

                $kelas = $kelasCache[$key];

                $ipk = isset($row['ipk'])
                    ? str_replace(',', '.', $row['ipk'])
                    : 0;

                $dataMahasiswa[] = [
                    'user_id' => $users[$nipd],
                    'nipd' => $nipd,
                    'kelas_id' => $kelas->id,
                    'jk' => $row['jk'],
                    'no_hp' => $row['no_hp'],
                    'domisili' => $row['domisili'] ?? null,
                    'status_akademik' => $row['status'] ?? 'aktif',
                    'status_kerja' => 'available',
                    'ipk' => $ipk,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            // insert mahasiswa batch
            Mahasiswa::insert($dataMahasiswa);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function getReport()
    {
        return $this->report;
    }
}
