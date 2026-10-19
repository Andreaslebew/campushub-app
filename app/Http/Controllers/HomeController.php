<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data dummy postingan threads mahasiswa untuk halaman FYP
        $posts = [
            [
                'penulis' => 'Budi_Teknik', 
                'konten' => 'Cari teman sekelompok buat hackathon minggu depan, sisa 1 orang lagi khusus anak koding frontend.', 
                'prodi' => 'Teknik Informatika', 
                'kampus' => 'Universitas Brawijaya',
                'scope' => 'FYP',
                'interaksi' => 15,
                'komentar' => 8
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
            [
                'penulis' => 'Siti_Bisnis', 
                'konten' => 'Mau tanya karakteristik dosen pengampu Statistik Bisnis semester ini gimana ya? Tips lulus tugasnya apa aja?', 
                'prodi' => 'Administrasi Bisnis', 
                'kampus' => 'Universitas Negeri Malang',
                'scope' => 'Kampus',
                'interaksi' => 10,
                'komentar' => 3
            ],
        ];

        return view('beranda', compact('posts'));
    }

    public function tentang()
    {
        return view('tentang');
    }
}