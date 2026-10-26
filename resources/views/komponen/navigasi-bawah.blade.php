@php
    $menu = [
        ['url' => url('/'), 'aktif' => request()->is('/'), 'ikon' => 'home'],
        ['url' => route('post.create'), 'aktif' => request()->is('buat*'), 'ikon' => 'plus'],
        ['url' => route('akun.index'), 'aktif' => request()->is('akun*'), 'ikon' => 'profil'],
    ];
@endphp

<nav class="fixed inset-x-0 bottom-0 z-50 border-t border-neutral-200 bg-white">
    <div class="mx-auto flex max-w-md items-center justify-around py-2">
        @foreach ($menu as $item)
            <a href="{{ $item['url'] }}"
                class="flex flex-1 justify-center py-2 transition {{ $item['aktif'] ? 'text-neutral-900' : 'text-neutral-400 hover:text-neutral-700' }}">

                @if ($item['ikon'] === 'home')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1v-9.5z" />
                    </svg>
                @elseif ($item['ikon'] === 'plus')
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" d="M12 8v8M8 12h8" />
                    </svg>
                @else
                    <svg class="h-7 w-7" fill="{{ $item['aktif'] ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <circle cx="12" cy="8" r="4" />
                        <path stroke-linecap="round" d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7z" />
                    </svg>
                @endif
            </a>
        @endforeach
    </div>
</nav>