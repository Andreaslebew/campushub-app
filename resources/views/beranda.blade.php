@extends('layouts.app')
@section('title', 'Beranda / FYP')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">🔥 Linimasa FYP (Random)</h3>
            <span class="text-muted small">Menampilkan diskusi populer lintas kampus & prodi</span>
        </div>

        {{-- Perulangan data dummy menggunakan @forelse dan memanggil @include komponen --}}
        @forelse($posts as $p)
            @include('komponen.kartu-post', ['post' => $p])
        @empty
            <div class="alert alert-info text-center">Belum ada postingan saat ini.</div>
        @endforelse
    </div>
</div>
@endsection