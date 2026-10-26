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
        $semua = DummyData::posts();
        $disukai = session('disukai', []);

        $postingan = array_values(array_filter($semua, fn ($p) => $p['penulis'] === $user->name));
        $disukaiList = array_values(array_filter($semua, fn ($p) => in_array($p['id'], $disukai, true)));

        $tab = $request->query('tab') === 'disukai' ? 'disukai' : 'postingan';
        $daftar = $tab === 'disukai' ? $disukaiList : $postingan;

        return view('akun.index', compact('user', 'tab', 'daftar', 'postingan', 'disukaiList'));
    }
}