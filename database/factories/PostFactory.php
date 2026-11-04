<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'user_id' => $user->id,
            'penulis' => $user->name,
            'kampus' => $user->kampus,
            'kota' => $user->kota,
            'prodi' => $user->prodi,
            'scope' => fake()->randomElement(['Kota', 'Kampus']),
            'konten' => fake()->sentence(12),
            'suka' => fake()->numberBetween(0, 40),
            'komentar' => fake()->numberBetween(0, 15),
        ];
    }
}