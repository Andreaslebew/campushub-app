<?php

namespace App\Http\Controllers;

use App\Support\DummyData;

class NotifikasiController extends Controller
{
    public function index()
    {
        /** @var array<int, array{id: int, tipe: string, pesan: string, waktu: string, dibaca: bool, post_id: int|null}> $notifikasi */
        $notifikasi = DummyData::notifikasi();

        return view('notifikasi', compact('notifikasi'));
    }

    public function baca(int $id)
    {
        $sudahDibaca = session('notifikasi_dibaca', []);
        if (! in_array($id, $sudahDibaca, true)) {
            $sudahDibaca[] = $id;
            session(['notifikasi_dibaca' => $sudahDibaca]);
        }

        $notif = collect(DummyData::notifikasi())->firstWhere('id', $id);
        $postId = $notif['post_id'] ?? 1;

        return redirect()->route('post.show', [
            'id' => $postId,
            'from' => route('notifikasi').'#notif-'.$id,
        ]);
    }
}
