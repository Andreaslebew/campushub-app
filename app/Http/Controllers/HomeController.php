<?php

namespace App\Http\Controllers;

use App\Support\DummyData;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return view('home', [
            'feed' => DummyData::feed($request),
            'daftarProdi' => DummyData::daftarProdi(),
        ]);
    }
}