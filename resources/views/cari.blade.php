@extends('layouts.app')

@section('content')
<div class="space-y-4">

    {{-- Search bar --}}
    <form method="GET" action="{{ route('cari') }}">
        <label class="flex w-full items-center gap-2 rounded-full border border-neutral-300 bg-white px-4 py-2.5 focus-within:border-neutral-900">
            <svg class="h-4 w-4 shrink-0 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
            <input
                type="search"
                name="q"
                value="{{ $q }}"
                placeholder="Cari postingan, topik, atau mahasiswa..."
                autofocus
                class="w-full border-0 bg-transparent p-0 text-sm placeholder:text-neutral-400 focus:ring-0">
        </label>
    </form>

    {{-- Hasil pencarian --}}
    @if ($q === '')
        <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-10 text-center text-sm text-neutral-400">
            Ketik sesuatu untuk mulai mencari.
        </div>
    @elseif (count($hasil) === 0)
        <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-10 text-center text-sm text-neutral-400">
            Tidak ada hasil untuk <span class="font-semibold text-neutral-700">"{{ $q }}"</span>.
        </div>
    @else
        <p class="text-xs text-neutral-500">{{ count($hasil) }} hasil untuk <span class="font-semibold">"{{ $q }}"</span></p>

        <div class="space-y-3">
            @foreach ($hasil as $item)
                @if ($item['tipe'] === 'event')
                    @include('komponen.kartu-event', ['event' => $item['data']])
                @else
                    @include('komponen.kartu-post', ['post' => $item['data']])
                @endif
            @endforeach
        </div>
    @endif

</div>
@endsection

