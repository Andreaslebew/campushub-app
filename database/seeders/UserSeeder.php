<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun untuk mencoba login: demo@campushub.test dengan kata sandi "password"
        User::factory()->create([
            'name' => 'Demo Mahasiswa',
            'email' => 'demo@campushub.test',
            'nim' => '2026000000',
            'prodi' => 'Informatika',
            'kota' => 'Malang',
            'kampus' => 'Universitas Brawijaya',
        ]);

        // Tiga mahasiswa untuk setiap kampus, supaya setiap forum kampus ada isinya
        foreach (config('akademik.kota') as $daftarKampus) {
            foreach ($daftarKampus as $kampus) {
                User::factory()->count(3)->kampus($kampus)->create();
            }
        }
    }
}