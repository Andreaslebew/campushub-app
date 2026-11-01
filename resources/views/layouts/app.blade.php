<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Campushub') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=ibm-plex-sans:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="min-h-screen flex flex-col font-sans text-neutral-900 antialiased">

        <!-- Navbar -->
        <nav id="navbar-utama" class="sticky top-0 z-50 border-b border-neutral-200 bg-white/90 backdrop-blur">
            @php
                $tabs = [
                    ['label' => 'FYP', 'url' => '/', 'aktif' => request()->is('/')],
                    ['label' => 'Forum Kota', 'url' => '/kota', 'aktif' => request()->is('kota*')],
                    ['label' => 'Forum Kampus', 'url' => '/kampus', 'aktif' => request()->is('kampus*')],
                    ['label' => 'Event', 'url' => '/event', 'aktif' => request()->is('event*')],
                ];
                $sembunyikanTab = request()->is('buat*', 'akun*', 'post/*', 'event/*', 'cari*', 'notifikasi*');
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

                <!-- Baris 2: tab navigasi + tombol filter -->
                @unless ($sembunyikanTab)
                    <div class="tab-bar-wrapper flex items-center border-t border-neutral-100 px-2">

                        {{-- Tab-tab --}}
                        <div class="tab-bar-tabs flex flex-1 overflow-x-auto">
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

                        {{-- Tombol filter (muncul jika halaman menyediakan konten filter) --}}
                        @hasSection('filter-panel')
                            <button type="button" id="tombol-filter-navbar"
                                class="relative ml-2 flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-neutral-300 text-neutral-600 transition hover:border-neutral-900 hover:text-neutral-900 active:bg-neutral-100"
                                aria-label="Buka filter">
                                {{-- Ikon slider / filter --}}
                                <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <line x1="4"  y1="6"  x2="20" y2="6"  stroke-linecap="round"/>
                                    <line x1="4"  y1="12" x2="20" y2="12" stroke-linecap="round"/>
                                    <line x1="4"  y1="18" x2="20" y2="18" stroke-linecap="round"/>
                                    <circle cx="9"  cy="6"  r="2.5" fill="white" stroke="currentColor"/>
                                    <circle cx="15" cy="12" r="2.5" fill="white" stroke="currentColor"/>
                                    <circle cx="9"  cy="18" r="2.5" fill="white" stroke="currentColor"/>
                                </svg>
                                {{-- Titik indikator filter aktif --}}
                                @yield('filter-aktif-indikator')
                            </button>
                        @endif
                    </div>

                    {{-- Panel filter (tersembunyi, toggle via JS) --}}
                    @hasSection('filter-panel')
                        <div id="panel-filter-navbar" class="hidden border-t border-neutral-100 bg-white px-4 py-3 shadow-sm">
                            @yield('filter-panel')
                        </div>
                    @endif
                @endunless
            </div>
        </nav>

        <!-- Desktop layout wrapper: sidebar | content | spacer -->
        <div class="desktop-layout-wrapper flex-1" style="--navbar-height: {{ $sembunyikanTab ? '3.5rem' : '6.8125rem' }};">

            {{-- Sidebar navigasi desktop (hidden on mobile via CSS) --}}
            <div class="desktop-sidebar-container">
                @include('komponen.navigasi-samping')
            </div>

            <!-- Konten utama -->
            <main class="main-content desktop-content-area w-full max-w-2xl flex-1 px-4 py-5 pb-24">
                @yield('content')
            </main>

            {{-- Right spacer for symmetry on desktop --}}
            <div class="desktop-spacer"></div>
        </div>

        <!-- Navigasi bawah (mobile only, hidden on desktop via CSS) -->
        @include('komponen.navigasi-bawah')

        <script>
            (function () {
                var nav = document.getElementById('navbar-utama');
                if (nav) {
                    var setNavH = function () {
                        document.documentElement.style.setProperty('--navbar-height', nav.offsetHeight + 'px');
                    };
                    setNavH();
                    window.addEventListener('resize', setNavH);
                }

                var btn   = document.getElementById('tombol-filter-navbar');
                var panel = document.getElementById('panel-filter-navbar');
                if (btn && panel) {
                    btn.addEventListener('click', function () {
                        var hidden = panel.classList.toggle('hidden');
                        btn.setAttribute('aria-expanded', hidden ? 'false' : 'true');
                        if (nav) {
                            setTimeout(function () {
                                document.documentElement.style.setProperty('--navbar-height', nav.offsetHeight + 'px');
                            }, 50);
                        }
                    });
                }

                if (window.location.hash) {
                    var el = document.querySelector(window.location.hash);
                    if (el) {
                        setTimeout(function () {
                            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 100);
                    }
                }
            })();
        </script>
    </body>
</html>
