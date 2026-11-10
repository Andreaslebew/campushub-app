<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('alasan', 50);
            $table->string('keterangan', 500)->nullable();
            $table->string('status', 20)->default('menunggu');
            $table->timestamps();

            $table->unique(['post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_posts');
    }
};