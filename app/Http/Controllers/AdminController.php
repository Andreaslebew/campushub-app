<?php

namespace App\Http\Controllers;

use App\Models\LaporanPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'jumlahPengguna' => User::count(),
            'jumlahPostingan' => Post::count(),
            'laporanMenunggu' => LaporanPost::where('status', LaporanPost::STATUS_MENUNGGU)->count(),
            'laporanTerbaru' => LaporanPost::with(['post', 'pelapor'])
                ->where('status', LaporanPost::STATUS_MENUNGGU)
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    public function postingan(Request $request): View
    {
        $q = trim((string) $request->query('q'));

        $posts = Post::query()
            ->withCount('laporan')
            ->when($q !== '', fn ($query) => $query
                ->where('konten', 'like', "%{$q}%")
                ->orWhere('penulis', 'like', "%{$q}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.postingan', compact('posts', 'q'));
    }

    /**
     * Menghapus postingan beserta file lampirannya. Laporan terkait ikut terhapus.
     */
    public function hapusPostingan(int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        foreach (['foto', 'video'] as $lampiran) {
            if ($post->{$lampiran} && File::exists(public_path($post->{$lampiran}))) {
                File::delete(public_path($post->{$lampiran}));
            }
        }

        $post->delete();

        return redirect()->route('admin.postingan')->with('sukses', 'Postingan berhasil dihapus.');
    }

    public function laporan(Request $request): View
    {
        $status = $request->query('status', LaporanPost::STATUS_MENUNGGU);
        $status = in_array($status, LaporanPost::STATUS, true) ? $status : LaporanPost::STATUS_MENUNGGU;

        $laporan = LaporanPost::with(['post', 'pelapor'])
            ->where('status', $status)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $ringkasan = LaporanPost::query()
            ->selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        return view('admin.laporan', compact('laporan', 'status', 'ringkasan'));
    }

    public function perbaruiLaporan(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(LaporanPost::STATUS)],
        ]);

        LaporanPost::findOrFail($id)->update(['status' => $data['status']]);

        return back()->with('sukses', 'Status laporan diperbarui.');
    }
}