<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PengaturanController extends Controller
{
    /**
     * Menampilkan halaman pengaturan akun. Fitur di dalamnya belum aktif.
     */
    public function index(): View
    {
        return view('pengaturan.index');
    }
}