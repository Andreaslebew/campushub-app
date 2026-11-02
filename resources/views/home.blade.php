@extends('layouts.app')

@php
    $urut = request('urut', 'teramai');
    $hanyaProdi = request()->boolean('hanya_prodi');
    $prodiSaya = auth()->user()?->prodi;
    $kotaSaya = auth()->user()?->kota;
    $kampusSaya = auth()->user()?->kampus;
@endphp

{{-- Indikator filter aktif (titik di tombol slider) --}}
@section('filter-aktif-indikator')
    @if ($hanyaProdi || $urut === 'terbaru')
        <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-neutral-900"></span>
    @endif
@endsection

{{-- Konten panel filter di navbar --}}
@section('filter-panel')
    <div class="space-y-3">

        {{-- Urutan --}}
        <div class="flex items-center gap-2">
            <span class="shrink-0 text-xs font-semibold text-neutral-500">Urutan</span>
            <a href="{{ request()->fullUrlWithQuery(['urut' => 'teramai']) }}"
                class="rounded-full border px-4 py-1.5 text-sm font-medium transition
                {{ $urut === 'teramai' ? 'border-neutral-900 bg-neutral-900 text-white' : 'border-neutral-300 bg-white text-neutral-700 hover:border-neutral-900' }}">
                Teramai
            </a>
            <a href="{{ request()->fullUrlWithQuery(['urut' => 'terbaru']) }}"
                class="rounded-full border px-4 py-1.5 text-sm font-medium transition
                {{ $urut === 'terbaru' ? 'border-neutral-900 bg-neutral-900 text-white' : 'border-neutral-300 bg-white text-neutral-700 hover:border-neutral-900' }}">
                Terbaru
            </a>
        </div>

        {{-- Filter prodi otomatis: tidak perlu memilih, cukup aktifkan --}}
        @if ($prodiSaya)
            <div class="flex flex-wrap items-center gap-2">
                <span class="shrink-0 text-xs font-semibold text-neutral-500">Prodi</span>
                <a href="{{ request()->fullUrlWithQuery(['hanya_prodi' => $hanyaProdi ? null : 1]) }}"
                    class="rounded-full border px-4 py-1.5 text-sm font-medium transition
                    {{ $hanyaProdi ? 'border-neutral-900 bg-neutral-900 text-white' : 'border-neutral-300 bg-white text-neutral-700 hover:border-neutral-900' }}">
                    {{ $hanyaProdi ? 'Hanya ' : '' }}{{ $prodiSaya }}
                </a>
            </div>
        @endif

        {{-- Info lingkup forum pengguna --}}
        @if (request()->is('kota*') && $kotaSaya)
            <p class="text-xs text-neutral-500">Menampilkan postingan dari kota <span class="font-semibold text-neutral-700">{{ $kotaSaya }}</span>.</p>
        @elseif (request()->is('kampus*') && $kampusSaya)
            <p class="text-xs text-neutral-500">Menampilkan postingan dari <span class="font-semibold text-neutral-700">{{ $kampusSaya }}</span>.</p>
        @endif

        @if ($hanyaProdi || $urut === 'terbaru')
            <a href="{{ url()->current() }}" class="inline-block text-xs text-neutral-400 underline hover:text-neutral-700">
                Reset filter
            </a>
        @endif
    </div>
@endsection

@section('content')
<div class="space-y-3">
    @forelse ($feed as $item)
        @if ($item['tipe'] === 'event')
            @include('komponen.kartu-event', ['event' => $item['data']])
        @else
            @include('komponen.kartu-post', ['post' => $item['data']])
        @endif
    @empty
        <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-8 text-center text-sm text-neutral-500">
            Belum ada postingan saat ini.
        </div>
    @endforelse
</div>
@endsection