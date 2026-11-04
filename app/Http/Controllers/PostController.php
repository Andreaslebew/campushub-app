<?php

namespace App\Http\Controllers;

use App\Support\DummyData;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $daftar = session("komentar.$id", []);
        $daftar[] = [
            'penulis' => Auth::check() ? Auth::user()->name : 'Anda',
            'isi' => $data['isi'] ?? '',
            'waktu' => 'baru saja',
            'foto' => $fotoPath,
            'video' => $videoPath,
            'lokasi' => $lokasiUrl,
            'lokasi_nama' => $lokasiNama,
        ];
        session(["komentar.$id" => $daftar]);

        $redirectParams = ['id' => $id];
        if ($request->filled('from')) {
            $redirectParams['from'] = $request->input('from');
        }

        return redirect()->route('post.show', $redirectParams)->with('sukses', 'Balasan berhasil dikirim.');
    }

    public function create()
    {
        return view('post.create', [
            'daftarProdi' => DummyData::daftarProdi(),
            'daftarKategori' => array_values(array_unique(array_column(DummyData::events(), 'kategori'))),
        ]);
    }

    public function store(Request $request)
    {
        $tipe = $request->input('tipe', 'post');

        if ($tipe === 'event') {
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

            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/posts'), $nama);
                $fotoPath = '/uploads/posts/'.$nama;
            }

            $videoPath = null;
            if ($request->hasFile('video')) {
                $file = $request->file('video');
                $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/posts'), $nama);
                $videoPath = '/uploads/posts/'.$nama;
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

            $baruEvent = session('events_baru', []);
            $baruEvent[] = [
                'id' => 5000 + count($baruEvent) + 1,
                'judul' => $data['judul'],
                'penyelenggara' => $data['penyelenggara'],
                'penulis' => Auth::user()->name,
                'kampus' => Auth::user()->kampus,
                'kota' => Auth::user()->kota,
                'kategori' => $data['kategori'],
                'scope' => $data['scope'],
                'tanggal' => $data['tanggal'],
                'waktu' => $data['waktu'],
                'lokasi' => $lokasiNama ?? 'Lokasi via Google Maps',
                'lokasi_url' => $lokasiUrl,
                'biaya' => $data['biaya'],
                'deskripsi' => $data['deskripsi'],
                'foto' => $fotoPath,
                'video' => $videoPath,
                'dibuat' => time(),
                'suka' => 0,
                'komentar' => 0,
            ];
            session(['events_baru' => $baruEvent]);

            return redirect()->route('akun.index', ['tab' => 'postingan'])->with('sukses', 'Event berhasil dipublikasikan.');
        }

        // Postingan biasa
        $data = $request->validate([
            'scope' => 'required|in:Kota,Kampus',
            'konten' => 'required|string|max:500',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:10240',
            'video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime,video/x-matroska|max:51200',
            'lokasi' => 'nullable|string|max:500',
            'lokasi_nama' => 'nullable|string|max:255',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $nama);
            $fotoPath = '/uploads/posts/'.$nama;
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $nama);
            $videoPath = '/uploads/posts/'.$nama;
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

        $baru = session('postingan_baru', []);

        Post::create([
            'user_id' => Auth::id(),
            'penulis' => Auth::user()->name,
            'kampus' => Auth::user()->kampus,
            'kota' => Auth::user()->kota,
            'prodi' => Auth::user()->prodi,
            'scope' => $data['scope'],
            'konten' => $data['konten'],
            'foto' => $fotoPath,
            'video' => $videoPath,
            'lokasi' => $lokasiUrl,
            'lokasi_nama' => $lokasiNama,
        ]);

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

    public function edit(int $id)
    {
        $post = collect(DummyData::posts())->firstWhere('id', $id);
        abort_if(! $post, 404);
        abort_if(($post['penulis'] ?? '') !== Auth::user()->name, 403);

        return view('post.edit', [
            'post' => $post,
            'daftarProdi' => DummyData::daftarProdi(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $post = collect(DummyData::posts())->firstWhere('id', $id);
        abort_if(! $post, 404);
        abort_if(($post['penulis'] ?? '') !== Auth::user()->name, 403);

        $data = $request->validate([
            'scope' => 'required|in:Kota,Kampus',
            'konten' => 'required|string|max:500',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,webp,gif|max:10240',
            'video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime,video/x-matroska|max:51200',
            'lokasi' => 'nullable|string|max:500',
            'lokasi_nama' => 'nullable|string|max:255',
        ]);

        $fotoPath = $post['foto'] ?? null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $nama);
            $fotoPath = '/uploads/posts/'.$nama;
        }

        $videoPath = $post['video'] ?? null;
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $nama = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/posts'), $nama);
            $videoPath = '/uploads/posts/'.$nama;
        }

        $lokasiUrl = $post['lokasi'] ?? null;
        $lokasiNama = $post['lokasi_nama'] ?? null;
        $lokasiRaw = ! empty($data['lokasi']) ? trim($data['lokasi']) : (! empty($data['lokasi_nama']) ? trim($data['lokasi_nama']) : null);
        if ($lokasiRaw) {
            if (str_starts_with($lokasiRaw, 'http://') || str_starts_with($lokasiRaw, 'https://')) {
                $lokasiUrl = $lokasiRaw;
            } else {
                $lokasiUrl = 'https://www.google.com/maps/search/?api=1&query='.urlencode($lokasiRaw);
            }
            $lokasiNama = ! empty($data['lokasi_nama']) ? trim($data['lokasi_nama']) : $lokasiRaw;
        }

        $edits = session('postingan_edit', []);
        Post::where('id', $id)->where('user_id', Auth::id())->update([
            'kampus' => Auth::user()->kampus,
            'kota' => Auth::user()->kota,
            'prodi' => Auth::user()->prodi,
            'scope' => $data['scope'],
            'konten' => $data['konten'],
            'foto' => $fotoPath,
            'video' => $videoPath,
            'lokasi' => $lokasiUrl,
            'lokasi_nama' => $lokasiNama,
        ]);        session(['postingan_edit' => $edits]);

        return redirect()->route('akun.index', ['tab' => 'postingan'])
            ->with('sukses', 'Postingan berhasil diperbarui.');
    }
}
