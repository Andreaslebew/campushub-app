<?php

namespace App\Http\Controllers;

use App\Support\DummyData;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $semua = DummyData::events();

        return view('event.index', [
            'events' => DummyData::filterEvents($semua, $request),
            'daftarKategori' => array_values(array_unique(array_column($semua, 'kategori'))),
        ]);
    }

    public function show(int $id)
    {
        $event = collect(DummyData::events())->firstWhere('id', $id);
        abort_if(! $event, 404);

        $komentar = array_merge(DummyData::komentarEvent($id), session("komentar_event.$id", []));

        return view('event.show', compact('event', 'komentar'));
    }

    public function komentar(Request $request, int $id)
    {
        abort_if(! collect(DummyData::events())->firstWhere('id', $id), 404);

        $data = $request->validate([
            'isi' => 'required|string|max:500',
        ]);

        $daftar = session("komentar_event.$id", []);
        $daftar[] = [
            'penulis' => 'Anda',
            'isi' => $data['isi'],
            'waktu' => 'baru saja',
        ];
        session(["komentar_event.$id" => $daftar]);

        return redirect()->route('event.show', $id)->with('sukses', 'Komentar berhasil dikirim.');
    }
}