<?php

use App\Models\Post;
use App\Models\User;

test('kota forum only shows posts from the same city as the user', function () {
    $user = User::factory()->create(['kota' => 'Surabaya']);

    Post::factory()->create([
        'kota' => 'Malang',
        'scope' => 'Kota',
        'konten' => 'Postingan dari Malang',
    ]);

    $this->actingAs($user)->get('/kota')->assertDontSee('Postingan dari Malang');
});

test('kota forum shows posts from the same city as the user', function () {
    $user = User::factory()->create(['kota' => 'Malang']);

    Post::factory()->create([
        'kota' => 'Malang',
        'scope' => 'Kota',
        'konten' => 'Postingan dari Malang',
    ]);

    $this->actingAs($user)->get('/kota')->assertSee('Postingan dari Malang');
});

test('kampus forum only shows posts from the same campus as the user', function () {
    $user = User::factory()->create(['kampus' => 'UIN Maulana Malik Ibrahim']);

    Post::factory()->create([
        'kampus' => 'UIN Maulana Malik Ibrahim',
        'scope' => 'Kampus',
        'konten' => 'Postingan kampus UIN',
    ]);

    Post::factory()->create([
        'kampus' => 'Universitas Brawijaya',
        'scope' => 'Kampus',
        'konten' => 'Postingan kampus UB',
    ]);

    $response = $this->actingAs($user)->get('/kampus');

    $response->assertStatus(200);
    $response->assertSee('Postingan kampus UIN');
    $response->assertDontSee('Postingan kampus UB');
});

test('prodi filter is applied automatically from the user profile', function () {
    $user = User::factory()->create([
        'kota' => 'Malang',
        'prodi' => 'Psikologi',
    ]);

    Post::factory()->create([
        'kota' => 'Malang',
        'prodi' => 'Teknik Informatika',
        'scope' => 'Kota',
        'konten' => 'Postingan TI',
    ]);

    $this->actingAs($user)->get('/kota?hanya_prodi=1')->assertDontSee('Postingan TI');
});

test('guests are redirected to register when opening the kampus forum', function () {
    $this->get('/kampus')->assertRedirect(route('register'));
});

test('guests are redirected to register when opening the kota forum', function () {
    $this->get('/kota')->assertRedirect(route('register'));
});