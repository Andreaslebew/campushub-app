<?php

use App\Models\User;

test('kota forum only shows posts from the same city as the user', function () {
    $user = User::factory()->create(['kota' => 'Surabaya', 'kampus' => 'Universitas Brawijaya']);

    $response = $this->actingAs($user)->get('/kota');

    $response->assertStatus(200);
    $response->assertDontSee('Cari teman sekelompok buat hackathon');
});

test('kota forum shows posts from the same city as the user', function () {
    $user = User::factory()->create(['kota' => 'Malang']);

    $response = $this->actingAs($user)->get('/kota');

    $response->assertStatus(200);
    $response->assertSee('Cari teman sekelompok buat hackathon');
});

test('kampus forum only shows posts from the same campus as the user', function () {
    $user = User::factory()->create(['kampus' => 'UIN Maulana Malik Ibrahim']);

    $response = $this->actingAs($user)->get('/kampus');

    $response->assertStatus(200);
    $response->assertSee('Lagi cari teman satu tim');
    $response->assertDontSee('Statistik Bisnis semester ini');
});

test('prodi filter is applied automatically from the user profile', function () {
    $user = User::factory()->create(['prodi' => 'Psikologi']);

    $response = $this->actingAs($user)->get('/kota?hanya_prodi=1');

    $response->assertStatus(200);
    $response->assertDontSee('Cari teman sekelompok buat hackathon');
});

test('guests can still view the forum without any filter', function () {
    $response = $this->get('/kampus');

    $response->assertStatus(200);
    $response->assertSee('Statistik Bisnis semester ini');
});