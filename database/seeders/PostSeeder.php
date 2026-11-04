<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $pengguna = User::all();

        // Setiap postingan ditulis oleh mahasiswa acak, sehingga kota dan kampusnya
        // mengikuti profil penulis dan muncul di forum yang tepat
        foreach (range(1, 80) as $nomor) {
            Post::factory()->oleh($pengguna->random())->create();
        }
    }
}