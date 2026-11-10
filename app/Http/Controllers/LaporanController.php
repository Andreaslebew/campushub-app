<?php

namespace App\Http\Controllers;

use App\Models\LaporanPost;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LaporanController extends Controller
{
    public function store(Request $request, int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        abort_if($post->user_id === Auth::id(), 403, 'Kamu tidak bisa melaporkan postinganmu sendiri.');

        $data = $request->validate([
            'alasan' => ['required', Rule::in(LaporanPost::ALASAN)],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        LaporanPost::firstOrCreate(
            ['post_id' => $post->id, 'user_id' => Auth::id()],
            ['alasan' => $data['alasan'], 'keterangan' => $data['keterangan'] ?? null]
        );

        return back()->with('sukses', 'Terima kasih, laporanmu sudah kami terima dan akan ditinjau admin.');
    }
}