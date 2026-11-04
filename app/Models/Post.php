<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'penulis', 'kampus', 'kota', 'prodi', 'scope', 'konten',
        'foto', 'video', 'lokasi', 'lokasi_nama', 'suka', 'komentar',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}