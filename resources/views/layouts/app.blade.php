<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Campushub') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-screen flex flex-col bg-neutral-100 font-sans text-neutral-900 antialiased">

        <!-- Navbar -->
        <nav class="sticky top-0 z-50 border-b border-neutral-200 bg-white/90 backdrop-blur">
            @php
                $tabs = [
                    ['label' => 'FYP', 'url' => '/', 'aktif' => request()->is('/')],
                    ['label' => 'Forum Kota', 'url' => '/kota', 'aktif' => request()->is('kota*')],
                    ['label' => 'Forum Kampus', 'url' => '/kampus', 'aktif' => request()->is('kampus*')],
                    ['label' => 'Event', 'url' => '/event', 'aktif' => request()->is('event*')],
                ];
                $sembunyikanTab = request()->is('buat*', 'akun*', 'post/*', 'event/*');
            @endphp

            <div class="mx-auto max-w-6xl">

                <!-- Baris 1: logo dan tombol tamu -->
                <div class="flex h-14 items-center justify-between px-4">
                    <a href="/" class="flex shrink-0 items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg border-2 border-neutral-900 text-sm font-bold">C</span>
                        <span class="text-lg font-bold tracking-tight">Campushub</span>
                    </a>

                    <div class="flex shrink-0 items-center gap-2">
                        @guest
                            <a href="{{ route('login') }}"
                                class="rounded-full px-3 py-1.5 text-sm font-semibold text-neutral-700 hover:bg-neutral-100">Masuk</a>
                            <a href="{{ route('register') }}"
                                class="rounded-full bg-neutral-900 px-3 py-1.5 text-sm font-semibold text-white hover:bg-neutral-700">Daftar</a>
                        @endguest
                    </div>
                </div>

                <!-- Baris 2: tab navigasi, disembunyikan di halaman Buat dan Akun -->
                @unless ($sembunyikanTab)
                    <div class="flex justify-start overflow-x-auto px-2 sm:justify-center sm:gap-6">
                        @foreach ($tabs as $tab)
                            <a href="{{ $tab['url'] }}"
                                class="relative flex h-11 shrink-0 items-center whitespace-nowrap px-3 text-sm transition
                                {{ $tab['aktif'] ? 'font-bold text-neutral-900' : 'text-neutral-500 hover:text-neutral-900' }}">
                                {{ $tab['label'] }}
                                @if ($tab['aktif'])
                                    <span class="absolute inset-x-3 bottom-0 h-[3px] rounded-full bg-neutral-900"></span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endunless
            </div>
        </nav>

        <!-- Konten utama -->
        <main class="mx-auto w-full max-w-2xl flex-1 px-4 py-5 pb-24">
            @yield('content')
        </main>

        <!-- Navigasi bawah -->
        @include('komponen.navigasi-bawah')
    </body>
</html>