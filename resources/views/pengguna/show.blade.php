@extends('layouts.app')

@section('content')
<div class="space-y-5">

    {{-- Kartu profil --}}
    <div class="rounded-2xl border border-neutral-200 bg-white p-5 sm:p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-neutral-200 text-xl font-bold text-neutral-600">
                {{ mb_strtoupper(mb_substr($pengguna->name, 0, 1)) }}
            </div>

            <div class="min-w-0 flex-1">
                <h1 class="truncate text-lg font-bold text-neutral-900">{{ $pengguna->name }}</h1>
                <p class="mt-0.5 truncate text-xs text-neutral-500">{{ $pengguna->prodi ?? '-' }}</p>
                <p class="truncate text-xs text-neutral-500">
                    {{ $pengguna->kampus ?? '-' }} · {{ $pengguna->kota ?? '-' }}
                </p>
            </div>
        </div>

        <div class="mt-4 border-t border-neutral-100 pt-4">
            <p class="text-sm text-neutral-600">
                <span class="font-semibold text-neutral-900">{{ count($postingan) }}</span> postingan ·
                <span class="font-semibold text-neutral-900">{{ count($postinganDisukai) }}</span> disukai
            </p>
        </div>
    </div>

    {{-- Tab --}}
    <div class="grid grid-cols-2 border-b border-neutral-200">
        <a href="{{ route('pengguna.show', ['id' => $pengguna->id, 'tab' => 'postingan']) }}"
            class="relative py-3 text-center text-sm transition
            {{ $tab === 'postingan' ? 'font-bold text-neutral-900' : 'text-neutral-500 hover:text-neutral-900' }}">
            Postingan
            @if ($tab === 'postingan')
                <span class="absolute inset-x-0 bottom-0 h-[3px] rounded-full bg-neutral-900"></span>
            @endif
        </a>

        <a href="{{ route('pengguna.show', ['id' => $pengguna->id, 'tab' => 'disukai']) }}"
            class="relative py-3 text-center text-sm transition
            {{ $tab === 'disukai' ? 'font-bold text-neutral-900' : 'text-neutral-500 hover:text-neutral-900' }}">
            Disukai
            @if ($tab === 'disukai')
                <span class="absolute inset-x-0 bottom-0 h-[3px] rounded-full bg-neutral-900"></span>
            @endif
        </a>
    </div>

    {{-- Daftar --}}
    <div class="space-y-3">
        @forelse ($daftar as $post)
            @include('komponen.kartu-post', ['post' => $post])
        @empty
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-8 text-center text-sm text-neutral-500">
                @if ($tab === 'disukai')
                    {{ $pengguna->name }} belum menyukai postingan apa pun.
                @else
                    {{ $pengguna->name }} belum membuat postingan.
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection