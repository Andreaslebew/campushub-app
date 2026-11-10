@php
    $menuAdmin = [
        ['url' => route('admin.dashboard'), 'label' => 'Ringkasan', 'aktif' => request()->routeIs('admin.dashboard')],
        ['url' => route('admin.laporan'), 'label' => 'Laporan', 'aktif' => request()->routeIs('admin.laporan*')],
        ['url' => route('admin.postingan'), 'label' => 'Postingan', 'aktif' => request()->routeIs('admin.postingan*')],
    ];
@endphp

<nav class="flex gap-2 overflow-x-auto">
    @foreach ($menuAdmin as $item)
        <a href="{{ $item['url'] }}"
            class="whitespace-nowrap rounded-full px-3.5 py-1.5 text-sm font-medium transition
            {{ $item['aktif'] ? 'bg-neutral-900 text-white' : 'border border-neutral-300 text-neutral-700 hover:border-neutral-900' }}">
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>