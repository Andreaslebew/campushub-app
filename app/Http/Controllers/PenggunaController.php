<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\DummyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    public function show(Request $request, int $id)
    {
        $pengguna = User::findOrFail($id);

        if ((int) Auth::id() === $pengguna->id) {
            return redirect()->route('akun.index', ['tab' => $request->query('tab')]);
        }

        $semuaPosts = DummyData::posts();
        $idDisukai = $pengguna->postsDisukai()->pluck('posts.id')->all();

        $postingan = array_values(array_filter(
            $semuaPosts,
            fn ($p) => (int) ($p['user_id'] ?? 0) === $pengguna->id
        ));

        $postinganDisukai = array_values(array_filter(
            $semuaPosts,
            fn ($p) => in_array($p['id'], $idDisukai, true)
        ));

        $tab = $request->query('tab') === 'disukai' ? 'disukai' : 'postingan';
        $daftar = $tab === 'disukai' ? $postinganDisukai : $postingan;

        return view('pengguna.show', compact('pengguna', 'tab', 'daftar', 'postingan', 'postinganDisukai'));
    }
}