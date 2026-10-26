@extends('layouts.app')

@section('content')
<div class="space-y-5">

    @if (session('sukses'))
        <div class="rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('sukses') }}
        </div>
    @endif

    {{-- Kartu profil --}}
    <div class="rounded-2xl border border-neutral-200 bg-white p-5 sm:p-6">
        <div class="flex items-center gap-4">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-neutral-200 text-xl font-bold text-neutral-600">
                {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
            </div>

            <div class="min-w-0 flex-1">
                <h1 class="truncate text-lg font-bold text-neutral-900">{{ $user->name }}</h1>
                <p class="truncate text-sm text-neutral-500">{{ $user->email }}</p>
            </div>
        </div>

        <div class="mt-4 flex flex-wrap items-center justify-between gap-3 border-t border-neutral-100 pt-4">
            <p class="text-sm text-neutral-600">
                <span class="font-semibold text-neutral-900">{{ count($postingan) }}</span> postingan ·
                <span class="font-semibold text-neutral-900">{{ count($disukaiList) }}</span> disukai
            </p>

            <div class="flex items-center gap-2">
                <a href="{{ route('profile.edit') }}"
                    class="rounded-full border border-neutral-300 px-4 py-1.5 text-xs font-medium text-neutral-900 hover:bg-neutral-900 hover:text-white">
                    Edit profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="rounded-full border border-rose-200 px-4 py-1.5 text-xs font-medium text-rose-600 hover:bg-rose-600 hover:text-white">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Tab --}}
    <div class="grid grid-cols-2 border-b border-neutral-200">
        <a href="{{ route('akun.index', ['tab' => 'postingan']) }}"
            class="relative py-3 text-center text-sm transition
            {{ $tab === 'postingan' ? 'font-bold text-neutral-900' : 'text-neutral-500 hover:text-neutral-900' }}">
            Postingan saya
            @if ($tab === 'postingan')
                <span class="absolute inset-x-0 bottom-0 h-[3px] rounded-full bg-neutral-900"></span>
            @endif
        </a>

        <a href="{{ route('akun.index', ['tab' => 'disukai']) }}"
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
        @forelse ($daftar as $p)
            @include('komponen.kartu-post', ['post' => $p])
        @empty
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-8 text-center text-sm text-neutral-500">
                @if ($tab === 'disukai')
                    Belum ada postingan yang kamu sukai.
                @else
                    Belum ada postingan. Buat postingan pertamamu lewat tombol + di bawah.
                @endif
            </div>
        @endforelse
    </div>
</div>
@endsection