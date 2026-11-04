<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('penulis');
            $table->string('kampus')->nullable();
            $table->string('kota')->nullable();
            $table->string('prodi')->nullable();
            $table->enum('scope', ['Kota', 'Kampus']);
            $table->string('konten', 500);
            $table->string('foto')->nullable();
            $table->string('video')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('lokasi_nama')->nullable();
            $table->unsignedInteger('suka')->default(0);
            $table->unsignedInteger('komentar')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};