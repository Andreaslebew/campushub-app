<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'nim' => '2026000001',
        'prodi' => 'Teknik Informatika',
        'kota' => 'Malang',
        'kampus' => 'Universitas Brawijaya',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'nim' => '2026000001',
        'prodi' => 'Teknik Informatika',
        'kota' => 'Malang',
        'kampus' => 'Universitas Brawijaya',
    ]);
});

test('registration requires nim, prodi, kota, and kampus', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors(['nim', 'prodi', 'kota', 'kampus']);
    $this->assertGuest();
});

test('registration rejects a nim that is already used', function () {
    User::factory()->create(['nim' => '2026000002']);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'nim' => '2026000002',
        'prodi' => 'Teknik Informatika',
        'kota' => 'Malang',
        'kampus' => 'Universitas Brawijaya',
        'email' => 'baru@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertSessionHasErrors('nim');
});

test('kampus must belong to the selected kota', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'nim' => '2026000003',
        'prodi' => 'Informatika',
        'kota' => 'Surabaya',
        'kampus' => 'Universitas Brawijaya',
        'email' => 'salahkota@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('kampus');
});