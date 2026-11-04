@extends('layouts.app')

{{-- Indikator filter aktif (titik di tombol slider) --}}
@section('filter-aktif-indikator')
    @if (request('kategori') || request('scope') || request('q'))
        <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-neutral-900"></span>
    @endif
@endsection

{{-- Konten panel filter di navbar --}}
@section('filter-panel')
    <form method="GET" action="{{ route('event') }}" class="space-y-3">

        {{-- Search --}}
        <label class="flex w-full items-center gap-2 rounded-full border border-neutral-300 bg-white px-4 py-2 focus-within:border-neutral-900">
            <svg class="h-4 w-4 shrink-0 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
            <input type="search" name="q" value="{{ request('q') }}"
                placeholder="Cari nama event atau penyelenggara..."
                class="w-full border-0 bg-transparent p-0 text-sm placeholder:text-neutral-400 focus:ring-0">
        </label>

        {{-- Kategori & Scope --}}
        <div class="flex gap-2">
            <select name="kategori"
                class="min-w-0 flex-1 rounded-full border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
                <option value="">Semua kategori</option>
                @foreach ($daftarKategori as $k)
                    <option value="{{ $k }}" @selected(request('kategori') === $k)>{{ $k }}</option>
                @endforeach
            </select>

            @auth
                <select name="scope"
                    class="min-w-0 flex-1 rounded-full border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
                    <option value="">Kota & Kampus</option>
                    <option value="Kota" @selected(request('scope') === 'Kota')>Kota</option>
                    <option value="Kampus" @selected(request('scope') === 'Kampus')>Kampus</option>
                </select>
            @endauth
        </div>
        
        {{-- Aksi --}}
        <div class="flex gap-2">
            <button type="submit"
                class="flex-1 rounded-full bg-neutral-900 py-2 text-sm font-semibold text-white hover:bg-neutral-700">
                Terapkan
            </button>
            <a href="{{ route('event') }}"
                class="flex-1 rounded-full border border-neutral-300 py-2 text-center text-sm font-medium text-neutral-700 hover:border-neutral-900">
                Reset
            </a>
        </div>
    </form>
@endsection

@section('content')
<div class="space-y-4">

    <p class="text-sm text-neutral-500">{{ count($events) }} event ditemukan</p>

    <div class="space-y-3">
        @forelse ($events as $e)
            @include('komponen.kartu-event', ['event' => $e])
        @empty
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-8 text-center text-sm text-neutral-500">
                Belum ada event yang sesuai dengan filter.
            </div>
        @endforelse
    </div>
</div>
@endsection
