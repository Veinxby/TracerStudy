<?php

namespace App\Imports;

use App\Models\Jurusan;
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
        $nipds = $rows->pluck('nipd')->map(fn($n) => (string)$n)->toArray();

        // cek nipd yang sudah ada
        $existingNipd = Mahasiswa::whereIn('nipd', $nipds)
            ->pluck('nipd')
            ->toArray();

        $existingNipd = array_flip($existingNipd);

        // preload jurusan (biar ga query berulang)
        $jurusanMap = Jurusan::pluck('id', 'kode_jurusan')->toArray();

        $kelasCache = [];
        $dataUsers = [];
        $dataMahasiswa = [];
        $validNipds = [];
        $passwordCache = [];

        try {

            DB::beginTransaction();

            // =========================
            // LOOP 1 → INSERT USER
            // =========================
            foreach ($rows as $row) {

                $row = $row->toArray();

                $nipd = trim((string)$row['nipd']);
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
            if (!empty($dataUsers)) {
                User::insert($dataUsers);
            }

            // ambil id user
            $users = User::whereIn('username', $validNipds)
                ->pluck('id', 'username');

            // =========================
            // LOOP 2 → INSERT MAHASISWA
            // =========================
            foreach ($rows as $row) {

                $row = $row->toArray();

                $nipd = trim((string)$row['nipd']);

                if (!isset($users[$nipd])) {
                    continue;
                }

                // ===== FIX JURUSAN =====
                $kodeJurusan = trim($row['jurusan']);

                if (!isset($jurusanMap[$kodeJurusan])) {

                    $this->report['failed'][] = [
                        'nipd' => $nipd,
                        'nama' => $row['nama'],
                        'error' => 'Jurusan tidak ditemukan: ' . $kodeJurusan
                    ];

                    continue;
                }

                $jurusanId = $jurusanMap[$kodeJurusan];

                // cache kelas
                $key = $jurusanId . '-' . $row['kode_kelas'] . '-' . $row['tahun_masuk'];

                if (!isset($kelasCache[$key])) {

                    $kelasCache[$key] = Kelas::firstOrCreate([
                        'jurusan_id' => $jurusanId,
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
            if (!empty($dataMahasiswa)) {
                Mahasiswa::insert($dataMahasiswa);
            }

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
