<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function index(Request $request)
    {
        // Data dummy khusus forum 1 kota (misal: Malang)
        $posts = [
            [
                'penulis' => 'Andi_MhsMalang', 
                'konten' => 'Info kos bebas daerah sekitar Soekarno Hatta yang masih di bawah 1 juta per bulan dong, ada yang tau?', 
                'prodi' => 'Ilmu Komunikasi', 
                'kampus' => 'Universitas Muhammadiyah Malang',
                'scope' => 'Kota',
                'interaksi' => 30,
                'komentar' => 12
            ],
            [
                'penulis' => 'Rian_Informatika', 
                'konten' => 'Ada yang tau beli komponen ESP32 terdekat di sekitar Malang kota di mana ya yang stoknya lengkap?', 
                'prodi' => 'Teknik Informatika', 
                'kampus' => 'Universitas Bhinneka Nusantara',
                'scope' => 'Kota',
                'interaksi' => 25,
                'komentar' => 5
            ],
        ];

        return view('kota', compact('posts'));
    }
}