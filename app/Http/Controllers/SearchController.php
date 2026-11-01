<?php

namespace App\Http\Controllers;

use App\Support\DummyData;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $hasil = [];

        if ($q !== '') {
            $hasil = DummyData::feed($request);
        }

        return view('cari', compact('hasil', 'q'));
    }
}
