<?php

namespace App\Http\Controllers;

use App\Support\DummyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $semuaPosts = DummyData::posts();
        $semuaEvents = DummyData::events();
        $disukaiPosts = session('disukai', []);
        $disukaiEvents = session('disukai_event', []);

        // Postingan saya (post biasa dan event yang diposting oleh user)
        $userPosts = array_map(fn ($p) => ['tipe' => 'post', 'data' => $p, 'dibuat' => $p['dibuat'] ?? 0],
            array_values(array_filter($semuaPosts, fn ($p) => ($p['penulis'] ?? '') === $user->name))
        );

        $userEvents = array_map(fn ($e) => ['tipe' => 'event', 'data' => $e, 'dibuat' => $e['dibuat'] ?? 0],
            array_values(array_filter($semuaEvents, fn ($e) => ($e['penulis'] ?? '') === $user->name || ($e['penyelenggara'] ?? '') === $user->name))
        );

        $postingan = array_merge($userPosts, $userEvents);
        usort($postingan, fn ($a, $b) => ($b['dibuat'] ?? 0) <=> ($a['dibuat'] ?? 0));

        // Disukai list (posts dan events yang disukai)
        $likedPosts = array_map(fn ($p) => ['tipe' => 'post', 'data' => $p, 'dibuat' => $p['dibuat'] ?? 0],
            array_values(array_filter($semuaPosts, fn ($p) => in_array($p['id'], $disukaiPosts, true)))
        );

        $likedEvents = array_map(fn ($e) => ['tipe' => 'event', 'data' => $e, 'dibuat' => $e['dibuat'] ?? 0],
            array_values(array_filter($semuaEvents, fn ($e) => in_array($e['id'], $disukaiEvents, true)))
        );

        $disukaiList = array_merge($likedPosts, $likedEvents);
        usort($disukaiList, fn ($a, $b) => ($b['dibuat'] ?? 0) <=> ($a['dibuat'] ?? 0));

        $tab = $request->query('tab') === 'disukai' ? 'disukai' : 'postingan';
        $daftar = $tab === 'disukai' ? $disukaiList : $postingan;

        return view('akun.index', compact('user', 'tab', 'daftar', 'postingan', 'disukaiList'));
    }
}
