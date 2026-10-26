<?php

namespace App\Http\Controllers;

use App\Support\DummyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        abort_if(! collect(DummyData::posts())->firstWhere('id', $id), 404);

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

    public function create()
    {
        return view('post.create', [
            'daftarProdi' => DummyData::daftarProdi(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kampus' => 'required|string|max:100',
            'scope' => 'required|in:Kota,Kampus',
            'prodi' => ['required', Rule::in(DummyData::daftarProdi())],
            'konten' => 'required|string|max:500',
        ]);

        $baru = session('postingan_baru', []);

        $baru[] = [
            'id' => 1000 + count($baru) + 1,
            'dibuat' => time(),
            'penulis' => Auth::user()->name,
            'kampus' => $data['kampus'],
            'scope' => $data['scope'],
            'waktu' => 'baru saja',
            'konten' => $data['konten'],
            'prodi' => $data['prodi'],
            'suka' => 0,
            'komentar' => 0,
        ];

        session(['postingan_baru' => $baru]);

        return redirect()->route('akun.index', ['tab' => 'postingan'])
            ->with('sukses', 'Postingan berhasil diterbitkan.');
    }

    public function suka(int $id)
    {
        abort_if(! collect(DummyData::posts())->firstWhere('id', $id), 404);

        $disukai = session('disukai', []);

        $disukai = in_array($id, $disukai, true)
            ? array_values(array_diff($disukai, [$id]))
            : array_merge($disukai, [$id]);

        session(['disukai' => $disukai]);

        return back();
    }
}