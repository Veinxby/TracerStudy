<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('perusahaan')->insert([
            ['nama_perusahaan' => 'PT Teknologi Maju', 'kota' => 'Jakarta'],
            ['nama_perusahaan' => 'PT Digital Nusantara', 'kota' => 'Bandung'],
            ['nama_perusahaan' => 'CV Solusi Cerdas', 'kota' => 'Surabaya'],
        ]);
    }
}
