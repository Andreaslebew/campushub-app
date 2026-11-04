<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /** Contoh isi postingan forum kampus. */
    private const KONTEN_KAMPUS = [
        'Ada yang sudah ngerjain tugas Algoritma dan Struktur Data? Boleh bagi contoh solusinya buat belajar bareng.',
        'Jadwal UAS semester ini sudah keluar belum ya? Di portal saya belum kelihatan.',
        'Lagi cari teman kelompok untuk mata kuliah Basis Data, ada yang tertarik?',
        'Kantin fakultas hari ini penuh banget. Ada rekomendasi tempat makan yang dekat kampus?',
        'Dosen pembimbing skripsi susah ditemui. Ada tips supaya bimbingan tetap jalan?',
        'Ada yang tahu cara KRS ulang yang benar? Saya masih bingung di bagian pembayaran.',
        'Presentasi kelompok besok, ada yang mau latihan bareng sore ini di perpustakaan?',
        'Perpustakaan pusat buka sampai jam berapa minggu ini? Mau ngerjain tugas sampai malam.',
        'Info lomba karya tulis tingkat kampus dibuka sampai kapan ya?',
        'Ada yang mau sharing catatan kuliah Pemrograman Web minggu lalu? Saya kelewatan dua pertemuan.',
        'Organisasi mahasiswa di fakultas lagi buka open recruitment, ada yang mau gabung bareng?',
        'Kelas pengganti hari Jumat ruangannya di mana ya? Di jadwal belum tertulis.',
    ];

    /** Contoh isi postingan forum kota. */
    private const KONTEN_KOTA = [
        'Rekomendasi kafe yang tenang buat ngerjain tugas di kota ini apa ya?',
        'Ada yang tahu rute angkot dari terminal ke daerah kampus sekarang lewat mana?',
        'Lagi cari kos dekat kampus dengan harga yang masuk akal. Ada info dari teman-teman?',
        'Hari Minggu ini ada car free day di pusat kota nggak sih?',
        'Ada yang tahu laundry kiloan yang cepat dan murah di sekitar sini?',
        'Ada komunitas lari pagi di kota ini? Saya baru pindah dan mau cari teman olahraga.',
        'Pasar tradisional terdekat buka jam berapa ya? Mau belanja bahan masak untuk akhir pekan.',
        'Ada rekomendasi bengkel motor yang jujur dan tidak terlalu mahal?',
        'Tempat fotokopi yang buka malam sekitar kampus ada di mana saja?',
        'Lagi ada diskon di mall mana nih? Mau cari sepatu untuk kuliah.',
    ];

    /**
     * Default factory. Pemilik postingan biasanya diberikan lewat state oleh().
     */
    public function definition(): array
    {
        return [
            'user_id' => null,
            'penulis' => fake('id_ID')->name(),
            'kampus' => 'Universitas Brawijaya',
            'kota' => 'Malang',
            'prodi' => 'Teknik Informatika',
            'scope' => fake()->randomElement(['Kota', 'Kampus']),
            'konten' => fn (array $attributes) => $this->kontenUntuk($attributes['scope']),
            'suka' => fake()->numberBetween(0, 40),
            'komentar' => fake()->numberBetween(0, 15),
            'created_at' => fake()->dateTimeBetween('-14 days', 'now'),
        ];
    }

    /**
     * Postingan milik mahasiswa tertentu. Penulis, kampus, kota, dan prodi
     * otomatis diambil dari profilnya, sama seperti saat posting lewat aplikasi.
     */
    public function oleh(User $user): static
    {
        return $this->state(fn () => [
            'user_id' => $user->id,
            'penulis' => $user->name,
            'kampus' => $user->kampus,
            'kota' => $user->kota,
            'prodi' => $user->prodi,
        ]);
    }

    public function forumKampus(): static
    {
        return $this->state(fn () => ['scope' => 'Kampus']);
    }

    public function forumKota(): static
    {
        return $this->state(fn () => ['scope' => 'Kota']);
    }

    private function kontenUntuk(string $scope): string
    {
        $pilihan = $scope === 'Kampus' ? self::KONTEN_KAMPUS : self::KONTEN_KOTA;

        return fake()->randomElement($pilihan);
    }
}