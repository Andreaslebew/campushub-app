<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanPost extends Model
{
    public const ALASAN = ['Spam', 'Ujaran kebencian', 'Konten tidak pantas', 'Informasi palsu', 'Lainnya'];

    public const STATUS_MENUNGGU = 'menunggu';

    public const STATUS_DIABAIKAN = 'diabaikan';

    public const STATUS_DITINDAK = 'ditindak';

    public const STATUS = [self::STATUS_MENUNGGU, self::STATUS_DIABAIKAN, self::STATUS_DITINDAK];

    protected $fillable = ['post_id', 'user_id', 'alasan', 'keterangan', 'status'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}