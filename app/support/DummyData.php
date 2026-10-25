<?php

namespace App\Support;

use Illuminate\Http\Request;

class DummyData
{
    public static function posts(): array
    {
        return [
            [
                'id' => 1,
                'penulis' => 'Budi_Teknik',
                'kampus' => 'Universitas Brawijaya',
                'scope' => 'Kota',
                'waktu' => '2 jam lalu',
                'konten' => 'Cari teman sekelompok buat hackathon minggu depan, sisa 1 orang lagi khusus anak koding frontend.',
                'prodi' => 'Teknik Informatika',
                'suka' => 0,
                'komentar' => 8,
            ],
            [
                'id' => 2,
                'penulis' => 'Rian_Informatika',
                'kampus' => 'Universitas Bhinneka Nusantara',
                'scope' => 'Kota',
                'waktu' => '3 jam lalu',
                'konten' => 'Ada yang tahu beli komponen ESP32 terdekat di sekitar Malang kota di mana yang stoknya lengkap?',
                'prodi' => 'Teknik Informatika',
                'suka' => 0,
                'komentar' => 5,
            ],
            [
                'id' => 3,
                'penulis' => 'Siti_Bisnis',
                'kampus' => 'Universitas Negeri Malang',
                'scope' => 'Kampus',
                'waktu' => '5 jam lalu',
                'konten' => 'Mau tanya karakteristik dosen pengampu Statistik Bisnis semester ini gimana ya? Tips lulus tugasnya apa aja?',
                'prodi' => 'Administrasi Bisnis',
                'suka' => 0,
                'komentar' => 3,
            ],
            [
                'id' => 4,
                'penulis' => 'Alya_Psikologi',
                'kampus' => 'UIN Maulana Malik Ibrahim',
                'scope' => 'Kampus',
                'waktu' => '1 hari lalu',
                'konten' => 'Lagi cari teman satu tim untuk lomba karya tulis ilmiah tingkat nasional. Ada yang berminat?',
                'prodi' => 'Psikologi',
                'suka' => 0,
                'komentar' => 2,
            ],
        ];
    }

    public static function komentarEvent(int $id): array
    {
        $semua = [
            1 => [
                ['penulis' => 'Rizky_Informatika', 'isi' => 'Apakah sertifikat diberikan untuk peserta yang hadir penuh?', 'waktu' => '3 jam lalu'],
            ],
            2 => [
                ['penulis' => 'Ayu_Sastra', 'isi' => 'Untuk lomba ini, apakah boleh tim beranggotakan dua orang?', 'waktu' => '1 jam lalu'],
            ],
            3 => [
                ['penulis' => 'Dina_Komunikasi', 'isi' => 'Kamera pinjamannya tipe apa ya? Perlu bawa memory card sendiri?', 'waktu' => '5 jam lalu'],
            ],
            4 => [],
        ];

        return $semua[$id] ?? [];
    }

    public static function events(): array
    {
        return [
            [
                'id' => 1,
                'judul' => 'Seminar Nasional Kecerdasan Buatan',
                'penyelenggara' => 'HMIF Universitas Brawijaya',
                'kategori' => 'Seminar',
                'scope' => 'Kampus',
                'tanggal' => '2026-11-05',
                'waktu' => '08.00 - 12.00 WIB',
                'lokasi' => 'Gedung Teknik Informatika, Malang',
                'biaya' => 'Gratis',
                'deskripsi' => 'Seminar tentang penerapan AI di dunia kerja dan riset kampus, dengan pembicara dari industri.',
            ],
            [
                'id' => 2,
                'judul' => 'Lomba Karya Tulis Ilmiah Nasional',
                'penyelenggara' => 'UIN Maulana Malik Ibrahim',
                'kategori' => 'Lomba',
                'scope' => 'Kota',
                'tanggal' => '2026-11-12',
                'waktu' => 'Sepanjang hari',
                'lokasi' => 'Kota Malang (daring dan luring)',
                'biaya' => 'Rp 50.000',
                'deskripsi' => 'Lomba KTI terbuka untuk mahasiswa seluruh Indonesia dengan tema pendidikan dan teknologi.',
            ],
            [
                'id' => 3,
                'judul' => 'Workshop Fotografi Dasar',
                'penyelenggara' => 'UKM Fotografi Universitas Negeri Malang',
                'kategori' => 'Workshop',
                'scope' => 'Kampus',
                'tanggal' => '2026-11-20',
                'waktu' => '13.00 - 16.00 WIB',
                'lokasi' => 'Aula FIK UM',
                'biaya' => 'Rp 25.000',
                'deskripsi' => 'Pengenalan komposisi, eksposur, dan teknik dasar fotografi. Kamera dipinjamkan untuk peserta pemula.',
            ],
            [
                'id' => 4,
                'judul' => 'Bazar Kewirausahaan Mahasiswa',
                'penyelenggara' => 'Komunitas Wirausaha Malang',
                'kategori' => 'Bazar',
                'scope' => 'Kota',
                'tanggal' => '2026-12-01',
                'waktu' => '10.00 - 21.00 WIB',
                'lokasi' => 'Alun-alun Malang',
                'biaya' => 'Gratis',
                'deskripsi' => 'Bazar produk karya mahasiswa dengan talkshow singkat tentang memulai usaha sejak kuliah.',
            ],
        ];
    }

    public static function daftarProdi(): array
    {
        return ['Teknik Informatika', 'Administrasi Bisnis', 'Akuntansi', 'Pendidikan Seni Rupa', 'Psikologi'];
    }

    public static function filterPosts(array $posts, Request $request, ?string $scope = null): array
    {
        $q = strtolower(trim((string) $request->query('q', '')));
        $prodi = $request->query('prodi');
        $urut = $request->query('urut', 'teramai');

        $hasil = array_values(array_filter($posts, function ($p) use ($q, $prodi, $scope) {
            if ($scope && $p['scope'] !== $scope) {
                return false;
            }
            if ($prodi && $p['prodi'] !== $prodi) {
                return false;
            }
            if ($q !== '') {
                $teks = strtolower($p['konten'].' '.$p['penulis'].' '.$p['kampus']);
                if (! str_contains($teks, $q)) {
                    return false;
                }
            }
            return true;
        }));

        if ($urut === 'terbaru') {
            usort($hasil, fn ($a, $b) => $b['id'] <=> $a['id']);
        } else {
            usort($hasil, fn ($a, $b) => $b['komentar'] <=> $a['komentar']);
        }

        return $hasil;
    }

    public static function filterEvents(array $events, Request $request): array
    {
        $q = strtolower(trim((string) $request->query('q', '')));
        $kategori = $request->query('kategori');
        $scope = $request->query('scope');

        $hasil = array_values(array_filter($events, function ($e) use ($q, $kategori, $scope) {
            if ($kategori && $e['kategori'] !== $kategori) {
                return false;
            }
            if ($scope && $e['scope'] !== $scope) {
                return false;
            }
            if ($q !== '') {
                $teks = strtolower($e['judul'].' '.$e['penyelenggara'].' '.$e['deskripsi']);
                if (! str_contains($teks, $q)) {
                    return false;
                }
            }
            return true;
        }));

        usort($hasil, fn ($a, $b) => strcmp($a['tanggal'], $b['tanggal']));

        return $hasil;
    }

    public static function feed(Request $request, ?string $scope = null): array
    {
        $items = [];

        foreach (self::filterPosts(self::posts(), $request, $scope) as $p) {
            $items[] = [
                'tipe' => 'post',
                'data' => $p,
                'komentar' => $p['komentar'],
                'sortId' => $p['id'],
            ];
        }

        // Event disembunyikan saat filter prodi dipilih, karena event tidak punya prodi
        if (! $request->query('prodi')) {
            $events = self::filterEvents(self::events(), $request);

            if ($scope) {
                $events = array_values(array_filter($events, fn ($e) => $e['scope'] === $scope));
            }

            foreach ($events as $e) {
                $items[] = [
                    'tipe' => 'event',
                    'data' => $e,
                    'komentar' => count(self::komentarEvent($e['id'])),
                    'sortId' => $e['id'],
                ];
            }
        }

        $terbaru = $request->query('urut') === 'terbaru';

        usort($items, fn ($a, $b) => $terbaru
            ? $b['sortId'] <=> $a['sortId']
            : $b['komentar'] <=> $a['komentar']);

        return $items;
    }
}