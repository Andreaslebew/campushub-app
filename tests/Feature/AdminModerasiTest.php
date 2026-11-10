<?php

use App\Models\LaporanPost;
use App\Models\Post;
use App\Models\User;

test('akun admin dibuat otomatis oleh migrasi', function () {
    $this->assertDatabaseHas('users', [
        'email' => env('ADMIN_EMAIL', 'admin@campushub.test'),
        'role' => 'admin',
    ]);
});

test('tamu diarahkan ke halaman login', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
});

test('user biasa tidak bisa membuka panel admin', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
});

test('admin bisa membuka panel admin', function () {
    $admin = User::where('role', 'admin')->firstOrFail();

    $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
});

test('admin bisa menghapus postingan beserta laporannya', function () {
    $admin = User::where('role', 'admin')->firstOrFail();
    $post = Post::factory()->create();
    LaporanPost::create([
        'post_id' => $post->id,
        'user_id' => User::factory()->create()->id,
        'alasan' => 'Spam',
    ]);

    $this->actingAs($admin)
        ->delete(route('admin.postingan.destroy', $post->id))
        ->assertRedirect(route('admin.postingan'));

    $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    $this->assertDatabaseMissing('laporan_posts', ['post_id' => $post->id]);
});

test('user biasa tidak bisa menghapus postingan', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($user)
        ->delete(route('admin.postingan.destroy', $post->id))
        ->assertForbidden();

    $this->assertDatabaseHas('posts', ['id' => $post->id]);
});

test('pengguna bisa melaporkan postingan dan laporan ganda tidak tercatat dua kali', function () {
    $pelapor = User::factory()->create();
    $post = Post::factory()->create();

    $this->actingAs($pelapor)
        ->post(route('post.lapor', $post->id), ['alasan' => 'Spam'])
        ->assertSessionHas('sukses');

    $this->actingAs($pelapor)
        ->post(route('post.lapor', $post->id), ['alasan' => 'Spam']);

    $this->assertDatabaseCount('laporan_posts', 1);
});

test('admin bisa menandai laporan sebagai ditindak', function () {
    $admin = User::where('role', 'admin')->firstOrFail();
    $post = Post::factory()->create();
    $laporan = LaporanPost::create([
        'post_id' => $post->id,
        'user_id' => User::factory()->create()->id,
        'alasan' => 'Konten tidak pantas',
    ]);

    $this->actingAs($admin)
        ->patch(route('admin.laporan.update', $laporan->id), ['status' => 'ditindak']);

    $this->assertDatabaseHas('laporan_posts', ['id' => $laporan->id, 'status' => 'ditindak']);
});