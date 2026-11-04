<?php

use App\Models\Post;
use App\Models\User;

test('events posted by user appear on their profile page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/buat', [
        'tipe' => 'event',
        'judul' => 'Event Spesial Kampus Kita',
        'penyelenggara' => $user->name,
        'kategori' => 'Workshop',
        'scope' => 'Kampus',
        'tanggal' => '2026-12-01',
        'waktu' => '09.00 WIB',
        'biaya' => 'Gratis',
        'deskripsi' => 'Deskripsi event kampus yang diposting oleh user.',
    ]);

    $response = $this->actingAs($user)->get(route('akun.index', ['tab' => 'postingan']));
    $response->assertStatus(200);
    $response->assertSee('Event Spesial Kampus Kita');
    $response->assertSee('Edit');
});

test('posts on profile page show edit button and can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/buat', [
        'tipe' => 'post',
        'scope' => 'Kampus',
        'konten' => 'Postingan awal untuk uji coba edit.',
    ]);

    $response = $this->actingAs($user)->get(route('akun.index', ['tab' => 'postingan']));
    $response->assertStatus(200);
    $response->assertSee('Postingan awal untuk uji coba edit.');
    $response->assertSee('Edit');

    $post = Post::latest('id')->firstOrFail();

    $editPage = $this->actingAs($user)->get(route('post.edit', $post->id));
    $editPage->assertStatus(200);
    $editPage->assertSee('Edit Postingan');

    $updateResponse = $this->actingAs($user)->put(route('post.update', $post->id), [
        'scope' => 'Kota',
        'konten' => 'Konten postingan berhasil diubah.',
    ]);

    $updateResponse->assertRedirect();

    $this->assertDatabaseHas('posts', [
        'id' => $post->id,
        'konten' => 'Konten postingan berhasil diubah.',
        'scope' => 'Kota',
    ]);

    $profileAfter = $this->actingAs($user)->get(route('akun.index', ['tab' => 'postingan']));
    $profileAfter->assertSee('Konten postingan berhasil diubah.');

    while (ob_get_level() > 0) {
        ob_end_clean();
    }
});