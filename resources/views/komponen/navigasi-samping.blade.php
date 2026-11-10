@php
    $jumlahNotifikasiBelumDibaca = auth()->check()
        ? collect(App\Support\DummyData::notifikasi())->where('dibaca', false)->count()
        : 0;
        
    $menuSamping = [
        ['url' => url('/'),                                                   'aktif' => request()->is('/', 'kota*', 'kampus*'), 'ikon' => 'home',    'label' => 'Beranda'],
        ['url' => route('cari'),                                              'aktif' => request()->is('cari*'),                 'ikon' => 'search',  'label' => 'Pencarian'],
        ['url' => route('post.create'),                                       'aktif' => request()->is('buat*'),                 'ikon' => 'plus',    'label' => 'Buat Post'],
        ['url' => auth()->check() ? route('notifikasi') : route('login'),    'aktif' => request()->is('notifikasi*'),            'ikon' => 'bell',    'label' => 'Notifikasi'],
        ['url' => route('akun.index'),                                        'aktif' => request()->is('akun*'),                 'ikon' => 'profil',  'label' => 'Profil'],
    ];
    if (auth()->check() && auth()->user()->isAdmin()) {
        $menuSamping[] = ['url' => route('admin.dashboard'), 'aktif' => request()->is('admin*'), 'ikon' => 'admin', 'label' => 'Admin'];
    }
@endphp

<aside class="sidebar-nav">
    @foreach ($menuSamping as $item)
        <a href="{{ $item['url'] }}"
            class="sidebar-nav-link {{ $item['aktif'] ? 'active' : '' }}">

            @if ($item['ikon'] === 'home')
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5L12 3l9 7.5V20a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1v-9.5z" />
                </svg>

            @elseif ($item['ikon'] === 'search')
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>

            @elseif ($item['ikon'] === 'plus')
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" />
                    <path stroke-linecap="round" d="M12 8v8M8 12h8" />
                </svg>

            @elseif ($item['ikon'] === 'bell')
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>

            @elseif ($item['ikon'] === 'admin')
                <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
                
            @else
                <svg fill="{{ $item['aktif'] ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="8" r="4" />
                    <path stroke-linecap="round" d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7z" />
                </svg>
            @endif

            <span>{{ $item['label'] }}</span>

            @if ($item['ikon'] === 'bell' && $jumlahNotifikasiBelumDibaca > 0)
                <span class="sidebar-nav-badge">
                    {{ $jumlahNotifikasiBelumDibaca > 9 ? '9+' : $jumlahNotifikasiBelumDibaca }}
                </span>
            @endif
        </a>
    @endforeach
</aside>
