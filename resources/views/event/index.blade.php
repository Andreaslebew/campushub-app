@extends('layouts.app')

@section('content')
<div class="space-y-4">

    <form method="GET" action="{{ route('event') }}" class="flex flex-wrap items-center gap-2">
        <label class="flex min-w-[12rem] flex-1 items-center gap-2 rounded-full border border-neutral-300 bg-white px-4 py-2.5 focus-within:border-neutral-900">
            <svg class="h-4 w-4 shrink-0 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
            <input type="search" name="q" value="{{ request('q') }}"
                placeholder="Cari nama event atau penyelenggara..."
                class="w-full border-0 bg-transparent p-0 text-sm placeholder:text-neutral-400 focus:ring-0">
        </label>

        <select name="kategori" onchange="this.form.submit()"
            class="rounded-full border border-neutral-300 bg-white px-4 py-2.5 text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
            <option value="">Semua kategori</option>
            @foreach ($daftarKategori as $k)
                <option value="{{ $k }}" @selected(request('kategori') === $k)>{{ $k }}</option>
            @endforeach
        </select>

        <select name="scope" onchange="this.form.submit()"
            class="rounded-full border border-neutral-300 bg-white px-4 py-2.5 text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
            <option value="">Kota & Kampus</option>
            <option value="Kota" @selected(request('scope') === 'Kota')>Kota</option>
            <option value="Kampus" @selected(request('scope') === 'Kampus')>Kampus</option>
        </select>

        <button type="submit"
            class="rounded-full bg-neutral-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-neutral-700">
            Cari
        </button>
    </form>

    <p class="text-xs text-neutral-500">{{ count($events) }} event ditemukan</p>

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