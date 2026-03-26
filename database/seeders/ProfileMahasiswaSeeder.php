<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas = DB::table('kelas')->first();

        $mahasiswa = User::where('role', 'mahasiswa')->get();

        foreach ($mahasiswa as $mhs) {
            DB::table('profile_mahasiswa')->insert([
                'user_id' => $mhs->id,
                'kelas_id' => $kelas->id,
                'jenis_kelamin' => rand(0, 1) ? 'L' : 'P',
                'no_hp' => '08' . rand(1000000000, 9999999999),
                'status' => 'aktif',
            ]);
        }
    }
}
