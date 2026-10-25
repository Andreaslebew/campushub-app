<?php

namespace App\Http\Controllers;

use App\Support\DummyData;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function index(Request $request)
    {
        return view('home', [
            'feed' => DummyData::feed($request, 'Kota'),
            'daftarProdi' => DummyData::daftarProdi(),
        ]);
    }
}