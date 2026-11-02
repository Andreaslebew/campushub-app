<?php

use App\Models\User;

test('profile page links to the settings page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('akun.index'));

    $response->assertStatus(200);
    $response->assertSee(route('pengaturan.index'), false);
});

test('settings page shows features that are not yet clickable', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('pengaturan.index'));

    $response->assertStatus(200);
    $response->assertSee('Edit akun');
    $response->assertSee('Tema tampilan');
    $response->assertSee('Keluar');
    $response->assertSee('Segera hadir');
});

test('settings page requires authentication', function () {
    $this->get(route('pengaturan.index'))->assertRedirect(route('login'));
});