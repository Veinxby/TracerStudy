<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusan')->insert([
            [
                'kode' => 'ASE',
                'nama' => 'Application Software Engineering',
                'degree' => 'D2',
                'lama_studi' => 2,
            ],
            [
                'kode' => 'AIS',
                'nama' => 'Akuntansi Informasi Sistem',
                'degree' => 'D3',
                'lama_studi' => 3,
            ],
        ]);
    }
}
