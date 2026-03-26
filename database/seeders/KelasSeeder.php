<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ase = DB::table('jurusan')->where('kode', 'ASE')->first();
        $ais = DB::table('jurusan')->where('kode', 'AIS')->first();

        DB::table('kelas')->insert([
            [
                'jurusan_id' => $ase->id,
                'kode_kelas' => '56',
                'tahun_masuk' => 2022,
            ],
            [
                'jurusan_id' => $ais->id,
                'kode_kelas' => '67',
                'tahun_masuk' => 2023,
            ],
        ]);
    }
}
