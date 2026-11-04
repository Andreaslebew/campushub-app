<?php

namespace App\Support;

use Illuminate\Http\Request;

class DummyData
{
    public static function postsDasar(): array
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
                'lokasi' => 'https://www.google.com/maps/search/?api=1&query=Jl.+Soekarno+Hatta,+Kota+Malang',
                'lokasi_nama' => 'Jl. Soekarno Hatta, Kota Malang',
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

    public static function komentar(int $id): array
    {
        $semua = [
            1 => [
                ['penulis' => 'Dimas_Frontend', 'isi' => 'Saya bisa ikut, sudah pernah pakai Vue dan Tailwind untuk tugas kelompok.', 'waktu' => '1 jam lalu'],
                ['penulis' => 'Nadia_TI', 'isi' => 'Hackathonnya online atau offline? Lokasinya di mana ya?', 'waktu' => '45 menit lalu'],
            ],
            2 => [
                ['penulis' => 'Fajar_Elektro', 'isi' => 'Coba cek toko elektronik di sekitar Jalan Soekarno Hatta, biasanya stok ESP32 lebih lengkap.', 'waktu' => '2 jam lalu'],
            ],
            3 => [
                ['penulis' => 'Kevin_Manajemen', 'isi' => 'Dosennya tegas tapi jelas. Tugas dikumpulkan tepat waktu dan rapi, itu sudah cukup.', 'waktu' => '4 jam lalu'],
            ],
        ];

        return $semua[$id] ?? [];
    }

    /** Waktu upload dummy (dalam jam yang lalu) */
    private static function waktuDasar(): array
    {
        return [
            'post' => [1 => 2, 2 => 3, 3 => 5, 4 => 24],
            'event' => [1 => 48, 2 => 72, 3 => 96, 4 => 120],
        ];
    }

    public static function waktuRelatif(int $ts): string
    {
        $selisih = max(0, time() - $ts);

        if ($selisih < 60) {
            return 'baru saja';
        }
        if ($selisih < 3600) {
            return intdiv($selisih, 60).' menit lalu';
        }
        if ($selisih < 86400) {
            return intdiv($selisih, 3600).' jam lalu';
        }

        return intdiv($selisih, 86400).' hari lalu';
    }

    public static function jumlahKomentar(string $tipe, int $id): int
    {
        $dasar = $tipe === 'post' ? self::komentar($id) : self::komentarEvent($id);
        $sesi = session($tipe === 'post' ? "komentar.$id" : "komentar_event.$id", []);

        return count($dasar) + count($sesi);
    }

    public static function posts(): array
    {
        return \App\Models\Post::query()
            ->latest()
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'penulis' => $p->penulis,
                'kampus' => $p->kampus,
                'kota' => $p->kota,
                'prodi' => $p->prodi,
                'scope' => $p->scope,
                'konten' => $p->konten,
                'foto' => $p->foto,
                'video' => $p->video,
                'lokasi' => $p->lokasi,
                'lokasi_nama' => $p->lokasi_nama,
                'suka' => $p->suka,
                'komentar' => $p->komentar,
                'waktu' => $p->created_at->diffForHumans(),
                'dibuat' => $p->created_at->timestamp,
            ])
            ->all();
    }
    
    public static function events(): array
    {
        $disukai = session('disukai_event', []);
        $jamDasar = self::waktuDasar()['event'];
        $edits = session('events_edit', []);

        $semua = array_merge(self::eventsDasar(), session('events_baru', []));

        return array_map(function ($e) use ($disukai, $jamDasar, $edits) {
            if (isset($edits[$e['id']])) {
                $e = array_merge($e, $edits[$e['id']]);
            }
            $e['dibuat'] ??= time() - ($jamDasar[$e['id']] ?? 0) * 3600;
            $e['kota'] ??= 'Malang';
            $e['suka'] = in_array($e['id'], $disukai, true) ? 1 : ($e['suka'] ?? 0);
            $e['komentar'] = self::jumlahKomentar('event', $e['id']);

            return $e;
        }, $semua);
    }

        public static function feed(Request $request, ?string $scope = null): array
    {
        $items = [];

        foreach (self::filterPosts(self::posts(), $request, $scope) as $p) {
            $items[] = [
                'tipe' => 'post',
                'data' => $p,
                'skor' => $p['suka'] + $p['komentar'],
                'dibuat' => $p['dibuat'],
            ];
        }

        // Event disembunyikan saat filter "prodi saya" aktif, karena event tidak punya prodi
        if (! $request->boolean('hanya_prodi')) {
            $events = array_values(array_filter(
                self::filterEvents(self::events(), $request),
                fn ($e) => self::sesuaiForum($e, $scope)
            ));

            if ($scope) {
                $events = array_values(array_filter($events, fn ($e) => $e['scope'] === $scope));
            }

            foreach ($events as $e) {
                $items[] = [
                    'tipe' => 'event',
                    'data' => $e,
                    'skor' => $e['suka'] + $e['komentar'],
                    'dibuat' => $e['dibuat'],
                ];
            }
        }

        $terbaru = $request->query('urut') === 'terbaru';

        usort($items, function ($a, $b) use ($terbaru) {
            if ($terbaru) {
                return $b['dibuat'] <=> $a['dibuat'];
            }

            if ($b['skor'] !== $a['skor']) {
                return $b['skor'] <=> $a['skor'];
            }

            return $b['dibuat'] <=> $a['dibuat'];
        });

        return $items;
    }

    /**
     * Cek apakah postingan atau event berada di kota (forum kota) atau kampus (forum kampus)
     * yang sama dengan pengguna yang sedang login. Tamu dan pengguna tanpa data tersebut tidak difilter.
     *
     * @param  array<string, mixed>  $item
     */
    public static function sesuaiForum(array $item, ?string $scope): bool
    {
        $pengguna = auth()->user();

        if (! $scope || ! $pengguna) {
            return true;
        }

        if ($scope === 'Kota') {
            return ! $pengguna->kota || ($item['kota'] ?? null) === $pengguna->kota;
        }

        return ! $pengguna->kampus || ($item['kampus'] ?? null) === $pengguna->kampus;
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

    public static function eventsDasar(): array
    {
        return [
            [
                'id' => 1,
                'judul' => 'Seminar Nasional Kecerdasan Buatan',
                'penyelenggara' => 'HMIF Universitas Brawijaya',
                'kampus' => 'Universitas Brawijaya',
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
                'kampus' => 'UIN Maulana Malik Ibrahim',
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
                'kampus' => 'Universitas Negeri Malang',
                'kategori' => 'Workshop',
                'scope' => 'Kampus',
                'tanggal' => '2026-11-20',
                'waktu' => '13.00 - 16.00 WIB',
                'lokasi' => 'Aula FIK UM',
                'biaya' => 'Rp 25.000',
                'deskripsi' => 'Pengenalan komposisi, eksposur, dan teknik dasar fotografi. Kamera dipinjamkan untuk peserta pemula.',
            ],
        ];
    }

    /**
     * @return array<int, array{id: int, tipe: string, pesan: string, waktu: string, dibaca: bool, post_id: int|null}>
     */
    public static function notifikasi(): array
    {
        $sudahDibaca = session('notifikasi_dibaca', []);

        $daftar = [
            [
                'id' => 1,
                'tipe' => 'suka',
                'pesan' => 'Budi_Teknik menyukai postingan kamu.',
                'waktu' => '5 menit lalu',
                'dibaca' => false,
                'post_id' => 1,
            ],
            [
                'id' => 2,
                'tipe' => 'balasan',
                'pesan' => 'Dimas_Frontend membalas komentar kamu di postingan tentang hackathon.',
                'waktu' => '20 menit lalu',
                'dibaca' => false,
                'post_id' => 1,
            ],
            [
                'id' => 3,
                'tipe' => 'suka',
                'pesan' => 'Nadia_TI menyukai postingan kamu.',
                'waktu' => '1 jam lalu',
                'dibaca' => true,
                'post_id' => 2,
            ],
            [
                'id' => 4,
                'tipe' => 'balasan',
                'pesan' => 'Kevin_Manajemen membalas komentar kamu di thread Statistik Bisnis.',
                'waktu' => '3 jam lalu',
                'dibaca' => true,
                'post_id' => 3,
            ],
        ];

        return array_map(function ($item) use ($sudahDibaca) {
            if (in_array($item['id'], $sudahDibaca, true)) {
                $item['dibaca'] = true;
            }

            return $item;
        }, $daftar);
    }

    public static function daftarProdi(): array
    {
        return ['Teknik Informatika', 'Administrasi Bisnis', 'Akuntansi', 'Pendidikan Seni Rupa', 'Psikologi'];
    }

    public static function daftarKota(): array
    {
        return ['Malang', 'Surabaya', 'Jakarta', 'Bandung', 'Yogyakarta', 'Semarang'];
    }

    public static function daftarKampus(): array
    {
        return [
            'Universitas Brawijaya',
            'Universitas Bhinneka Nusantara',
            'Universitas Negeri Malang',
            'UIN Maulana Malik Ibrahim',
        ];
    }

    public static function filterPosts(array $posts, Request $request, ?string $scope = null): array
    {
        $q = strtolower(trim((string) $request->query('q', '')));
        $prodiSaya = $request->boolean('hanya_prodi') ? auth()->user()?->prodi : null;
        $urut = $request->query('urut', 'teramai');

        $hasil = array_values(array_filter($posts, function ($p) use ($q, $prodiSaya, $scope) {
            if ($scope && $p['scope'] !== $scope) {
                return false;
            }
            if (! self::sesuaiForum($p, $scope)) {
                return false;
            }
            if ($prodiSaya && $p['prodi'] !== $prodiSaya) {
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
            usort($hasil, fn ($a, $b) => ($b['dibuat'] ?? 0) <=> ($a['dibuat'] ?? 0));
        } else {
            // Default: 'teramai' diurutkan berdasarkan jumlah suka (like) dan komentar (balasan)
            usort($hasil, function ($a, $b) {
                $skorA = ($a['suka'] ?? 0) + ($a['komentar'] ?? 0);
                $skorB = ($b['suka'] ?? 0) + ($b['komentar'] ?? 0);

                if ($skorB !== $skorA) {
                    return $skorB <=> $skorA;
                }

                return ($b['dibuat'] ?? 0) <=> ($a['dibuat'] ?? 0);
            });
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
}
