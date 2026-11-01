@extends('layouts.app')

@section('content')
<div class="space-y-2">

    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-lg font-bold text-neutral-900">Notifikasi</h1>
        @php
            $unreadCount = collect($notifikasi)->where('dibaca', false)->count();
        @endphp
        @if ($unreadCount > 0)
            <span class="rounded-full bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-700">
                {{ $unreadCount }} belum dibaca
            </span>
        @endif
    </div>

    @forelse ($notifikasi as $item)
        <a href="{{ route('notifikasi.baca', $item['id']) }}"
            id="notif-{{ $item['id'] }}"
            class="scroll-mt-24 flex items-start gap-3 rounded-2xl border border-neutral-200 bg-white px-4 py-3.5 transition hover:border-neutral-400 hover:bg-neutral-50 active:bg-neutral-100
            {{ ! $item['dibaca'] ? 'border-l-4 border-l-neutral-900' : '' }}">

            {{-- Ikon tipe notifikasi --}}
            <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full
                {{ $item['tipe'] === 'suka' ? 'bg-rose-100 text-rose-500' : 'bg-blue-100 text-blue-500' }}">
                @if ($item['tipe'] === 'suka')
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.49-2.02-4.5-4.5-4.5-1.74 0-3.25 1-4 2.46C12.75 4.75 11.24 3.75 9.5 3.75 7.02 3.75 5 5.76 5 8.25c0 4.5 7 11.25 7 11.25s7-6.75 7-11.25z" />
                    </svg>
                @else
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                @endif
            </div>

            {{-- Pesan --}}
            <div class="min-w-0 flex-1">
                <p class="text-sm {{ ! $item['dibaca'] ? 'font-semibold text-neutral-900' : 'text-neutral-700' }}">
                    {{ $item['pesan'] }}
                </p>
                <div class="mt-1 flex items-center gap-2 text-xs text-neutral-400">
                    <span>{{ $item['waktu'] }}</span>
                    @if (!empty($item['post_id']))
                        <span>·</span>
                        <span class="text-neutral-600 hover:underline">Lihat postingan &rarr;</span>
                    @endif
                </div>
            </div>

            {{-- Titik penanda belum dibaca --}}
            @unless ($item['dibaca'])
                <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-neutral-900"></span>
            @endunless
        </a>
    @empty
        <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-10 text-center text-sm text-neutral-400">
            Belum ada notifikasi.
        </div>
    @endforelse

</div>
@endsection
