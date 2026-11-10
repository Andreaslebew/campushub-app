<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Membuat akun admin otomatis. Email dan kata sandi diambil dari .env.
     */
    public function up(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => env('ADMIN_EMAIL', 'admin@campushub.test')],
            [
                'name' => 'Admin Campushub',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'ganti-kata-sandi-ini')),
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        DB::table('users')->where('email', env('ADMIN_EMAIL', 'admin@campushub.test'))->delete();
    }
};