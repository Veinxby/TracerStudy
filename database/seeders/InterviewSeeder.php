<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perusahaan = DB::table('perusahaan')->pluck('id');
        $mahasiswa = User::where('role', 'mahasiswa')->get();

        foreach ($mahasiswa as $mhs) {
            for ($i = 1; $i <= 3; $i++) {
                DB::table('interviews')->insert([
                    'user_id' => $mhs->id,
                    'perusahaan_id' => $perusahaan->random(),
                    'posisi' => 'Junior Programmer',
                    'tgl_interview' => now()->subMonths(rand(1, 6)),
                    'metode' => rand(0, 1) ? 'online' : 'offline',
                    'hasil' => 'pending',
                ]);
            }
        }
    }
}
