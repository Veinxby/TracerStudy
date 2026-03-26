<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMIN
        User::create([
            'nipd' => 'ADM001',
            'nama' => 'Admin Tracer 1',
            'email' => 'admin1@mail.com',
            'password' => bcrypt('password'),
            'role' => 'adm_tracer',
        ]);

        User::create([
            'nipd' => 'ADM002',
            'nama' => 'Admin Tracer 2',
            'email' => 'admin2@mail.com',
            'password' => bcrypt('password'),
            'role' => 'adm_tracer',
        ]);

        // BRANCH MANAGER
        User::create([
            'nipd' => 'BM001',
            'nama' => 'Branch Manager',
            'email' => 'bm@mail.com',
            'password' => bcrypt('password'),
            'role' => 'bm',
        ]);

        // MAHASISWA
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'nipd' => 'MHS00' . $i,
                'nama' => 'Mahasiswa ' . $i,
                'email' => 'mhs' . $i . '@mail.com',
                'password' => bcrypt('password'),
                'role' => 'mhs',
            ]);
        }
    }
}
