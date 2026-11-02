@extends('layouts.app')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('akun.index') }}" aria-label="Kembali ke profil"
            class="flex h-9 w-9 items-center justify-center rounded-full border border-neutral-300 text-neutral-600 transition hover:border-neutral-900 hover:text-neutral-900">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-lg font-bold text-neutral-900">Pengaturan</h1>
    </div>

    {{-- Daftar pengaturan (belum aktif) --}}
    <div class="overflow-hidden rounded-2xl border border-neutral-200 bg-white">
        @php
            $daftarPengaturan = [
                ['label' => 'Edit akun', 'deskripsi' => 'Ubah nama, NIM, prodi, kota, dan kampus', 'ikon' => 'M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z'],
                ['label' => 'Tema tampilan', 'deskripsi' => 'Terang, gelap, atau mengikuti sistem', 'ikon' => 'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42'],
                ['label' => 'Notifikasi', 'deskripsi' => 'Atur notifikasi suka dan balasan', 'ikon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                ['label' => 'Privasi akun', 'deskripsi' => 'Atur siapa yang bisa melihat profilmu', 'ikon' => 'M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z'],
            ];
        @endphp

        @foreach ($daftarPengaturan as $item)
            <button type="button" disabled aria-disabled="true"
                class="flex w-full cursor-not-allowed items-center gap-4 border-b border-neutral-100 px-5 py-4 text-left opacity-60">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-neutral-100 text-neutral-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['ikon'] }}" />
                    </svg>
                </span>
                <span class="min-w-0 flex-1">
                    <span class="block text-sm font-semibold text-neutral-900">{{ $item['label'] }}</span>
                    <span class="block truncate text-xs text-neutral-500">{{ $item['deskripsi'] }}</span>
                </span>
                <span class="shrink-0 rounded-full border border-neutral-300 px-2.5 py-0.5 text-[11px] font-semibold text-neutral-500">Segera hadir</span>
            </button>
        @endforeach

        {{-- Keluar --}}
        <button type="button" disabled aria-disabled="true"
            class="flex w-full cursor-not-allowed items-center gap-4 px-5 py-4 text-left opacity-60">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-rose-50 text-rose-500">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
            </span>
            <span class="min-w-0 flex-1">
                <span class="block text-sm font-semibold text-rose-600">Keluar</span>
                <span class="block truncate text-xs text-neutral-500">Keluar dari akun Campushub</span>
            </span>
            <span class="shrink-0 rounded-full border border-neutral-300 px-2.5 py-0.5 text-[11px] font-semibold text-neutral-500">Segera hadir</span>
        </button>
    </div>

</div>
@endsection