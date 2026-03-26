<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perusahaan = DB::table('perusahaan')->pluck('id');
        $mahasiswa = User::where('role', 'mahasiswa')->get();

        foreach ($mahasiswa as $mhs) {
            for ($i = 1; $i <= 2; $i++) {
                DB::table('magang')->insert([
                    'user_id' => $mhs->id,
                    'perusahaan_id' => $perusahaan->random(),
                    'posisi' => 'Intern Developer',
                    'tanggal_mulai' => now()->subMonths(6),
                    'tanggal_selesai' => now()->subMonths(3),
                    'status' => 'selesai',
                ]);
            }
        }
    }
}
