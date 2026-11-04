<?php

namespace App\Http\Controllers;

use App\Support\DummyData;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        // Filter scope (Kota & Kampus) hanya untuk pengguna yang sudah login
        if (! auth()->check()) {
            $request->query->remove('scope');
        }

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
            'isi' => 'nullable|string|max:500',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:10240',
            'video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime,video/x-matroska|max:51200',
            'lokasi' => 'nullable|string|max:500',
            'lokasi_nama' => 'nullable|string|max:255',
        ]);

        if (empty($data['isi']) && ! $request->hasFile('foto') && ! $request->hasFile('video') && empty($data['lokasi']) && empty($data['lokasi_nama'])) {
            return back()->withErrors(['isi' => 'Tulis komentar atau sertakan foto/video/lokasi.'])->withInput();
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/komentar'), $nama);
            $fotoPath = '/uploads/komentar/'.$nama;
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/komentar'), $nama);
            $videoPath = '/uploads/komentar/'.$nama;
        }

        $lokasiUrl = null;
        $lokasiNama = null;
        $lokasiRaw = ! empty($data['lokasi']) ? trim($data['lokasi']) : (! empty($data['lokasi_nama']) ? trim($data['lokasi_nama']) : null);
        if ($lokasiRaw) {
            if (str_starts_with($lokasiRaw, 'http://') || str_starts_with($lokasiRaw, 'https://')) {
                $lokasiUrl = $lokasiRaw;
            } else {
                $lokasiUrl = 'https://www.google.com/maps/search/?api=1&query='.urlencode($lokasiRaw);
            }
            $lokasiNama = ! empty($data['lokasi_nama']) ? trim($data['lokasi_nama']) : $lokasiRaw;
        }

        $daftar = session("komentar_event.$id", []);
        $daftar[] = [
            'penulis' => auth()->check() ? auth()->user()->name : 'Anda',
            'isi' => $data['isi'] ?? '',
            'waktu' => 'baru saja',
            'foto' => $fotoPath,
            'video' => $videoPath,
            'lokasi' => $lokasiUrl,
            'lokasi_nama' => $lokasiNama,
        ];
        session(["komentar_event.$id" => $daftar]);

        $redirectParams = ['id' => $id];
        if ($request->filled('from')) {
            $redirectParams['from'] = $request->input('from');
        }

        return redirect()->route('event.show', $redirectParams)->with('sukses', 'Komentar berhasil dikirim.');
    }

    public function suka(int $id)
    {
        abort_if(! collect(DummyData::events())->firstWhere('id', $id), 404);

        $disukai = session('disukai_event', []);

        $disukai = in_array($id, $disukai, true)
            ? array_values(array_diff($disukai, [$id]))
            : array_merge($disukai, [$id]);

        session(['disukai_event' => $disukai]);

        return back();
    }

    public function edit(int $id)
    {
        $event = collect(DummyData::events())->firstWhere('id', $id);
        abort_if(! $event, 404);
        abort_if(($event['penulis'] ?? $event['penyelenggara']) !== auth()->user()->name && $event['penyelenggara'] !== auth()->user()->name, 403);

        $daftarKategori = array_values(array_unique(array_column(DummyData::events(), 'kategori')));

        return view('event.edit', [
            'event' => $event,
            'daftarKategori' => $daftarKategori,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $event = collect(DummyData::events())->firstWhere('id', $id);
        abort_if(! $event, 404);
        abort_if(($event['penulis'] ?? $event['penyelenggara']) !== auth()->user()->name && $event['penyelenggara'] !== auth()->user()->name, 403);

        $data = $request->validate([
            'judul' => 'required|string|max:150',
            'penyelenggara' => 'required|string|max:100',
            'scope' => 'required|in:Kota,Kampus',
            'kategori' => 'required|string|max:50',
            'tanggal' => 'required|date',
            'waktu' => 'required|string|max:100',
            'biaya' => 'required|string|max:50',
            'deskripsi' => 'required|string|max:1000',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:10240',
            'video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime,video/x-matroska|max:51200',
            'lokasi' => 'nullable|string|max:500',
            'lokasi_nama' => 'nullable|string|max:255',
        ]);

        $fotoPath = $event['foto'] ?? null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $nama);
            $fotoPath = '/uploads/posts/'.$nama;
        }

        $videoPath = $event['video'] ?? null;
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $nama);
            $videoPath = '/uploads/posts/'.$nama;
        }

        $lokasiUrl = $event['lokasi_url'] ?? null;
        $lokasiNama = $event['lokasi'] ?? null;
        $lokasiRaw = ! empty($data['lokasi']) ? trim($data['lokasi']) : (! empty($data['lokasi_nama']) ? trim($data['lokasi_nama']) : null);
        if ($lokasiRaw) {
            if (str_starts_with($lokasiRaw, 'http://') || str_starts_with($lokasiRaw, 'https://')) {
                $lokasiUrl = $lokasiRaw;
            } else {
                $lokasiUrl = 'https://www.google.com/maps/search/?api=1&query='.urlencode($lokasiRaw);
            }
            $lokasiNama = ! empty($data['lokasi_nama']) ? trim($data['lokasi_nama']) : $lokasiRaw;
        }

        $edits = session('events_edit', []);
        $edits[$id] = [
            'judul' => $data['judul'],
            'penyelenggara' => $data['penyelenggara'],
            'kategori' => $data['kategori'],
            'scope' => $data['scope'],
            'tanggal' => $data['tanggal'],
            'waktu' => $data['waktu'],
            'biaya' => $data['biaya'],
            'deskripsi' => $data['deskripsi'],
            'foto' => $fotoPath,
            'video' => $videoPath,
            'lokasi' => $lokasiNama,
            'lokasi_url' => $lokasiUrl,
        ];
        session(['events_edit' => $edits]);

        return redirect()->route('akun.index', ['tab' => 'postingan'])
            ->with('sukses', 'Event berhasil diperbarui.');
    }
}
