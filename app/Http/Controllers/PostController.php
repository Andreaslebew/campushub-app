<?php

namespace App\Http\Controllers;

use App\Support\DummyData;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(int $id)
    {
        $post = collect(DummyData::posts())->firstWhere('id', $id);
        abort_if(! $post, 404);

        $komentar = array_merge(DummyData::komentar($id), session("komentar.$id", []));

        return view('post.show', compact('post', 'komentar'));
    }

    public function komentar(Request $request, int $id)
    {
        $data = $request->validate([
            'isi' => 'required|string|max:500',
        ]);

        $daftar = session("komentar.$id", []);
        $daftar[] = [
            'penulis' => 'Anda',
            'isi' => $data['isi'],
            'waktu' => 'baru saja',
        ];
        session(["komentar.$id" => $daftar]);

        return redirect()->route('post.show', $id)->with('sukses', 'Balasan berhasil dikirim.');
    }
}