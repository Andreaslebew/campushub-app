@extends('layouts.app')

@php $urut = request('urut', 'teramai'); @endphp

{{-- Indikator filter aktif (titik di tombol slider) --}}
@section('filter-aktif-indikator')
    @if (request('prodi') || request('urut') === 'terbaru')
        <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-neutral-900"></span>
    @endif
@endsection

{{-- Konten panel filter di navbar --}}
@section('filter-panel')
    <form method="GET" action="{{ url()->current() }}" class="space-y-3">

        {{-- Urutan --}}
        <div class="flex items-center gap-2">
            <span class="shrink-0 text-xs font-semibold text-neutral-500">Urutan</span>
            <a href="{{ request()->fullUrlWithQuery(['urut' => 'teramai']) }}"
                class="rounded-full border px-4 py-1.5 text-sm font-medium transition
                {{ $urut === 'teramai' ? 'border-neutral-900 bg-neutral-900 text-white' : 'border-neutral-300 bg-white text-neutral-700 hover:border-neutral-900' }}">
                Teramai
            </a>
            <a href="{{ request()->fullUrlWithQuery(['urut' => 'terbaru']) }}"
                class="rounded-full border px-4 py-1.5 text-sm font-medium transition
                {{ $urut === 'terbaru' ? 'border-neutral-900 bg-neutral-900 text-white' : 'border-neutral-300 bg-white text-neutral-700 hover:border-neutral-900' }}">
                Terbaru
            </a>
        </div>

        {{-- Filter Prodi --}}
        <div class="flex items-center gap-2">
            <span class="shrink-0 text-xs font-semibold text-neutral-500">Prodi</span>
            <select name="prodi" onchange="this.form.submit()"
                class="min-w-0 flex-1 rounded-full border border-neutral-300 bg-white px-4 py-1.5 text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
                <option value="">Semua Prodi</option>
                @foreach ($daftarProdi ?? [] as $prodi)
                    <option value="{{ $prodi }}" @selected(request('prodi') === $prodi)>{{ $prodi }}</option>
                @endforeach
            </select>
            <input type="hidden" name="urut" value="{{ $urut }}">
        </div>

        @if (request('prodi') || request('urut') === 'terbaru')
            <a href="{{ url()->current() }}" class="inline-block text-xs text-neutral-400 hover:text-neutral-700 underline">
                Reset filter
            </a>
        @endif
    </form>
@endsection

@section('content')
<div class="space-y-3">
    @forelse ($feed as $item)
        @if ($item['tipe'] === 'event')
            @include('komponen.kartu-event', ['event' => $item['data']])
        @else
            @include('komponen.kartu-post', ['post' => $item['data']])
        @endif
    @empty
        <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-8 text-center text-sm text-neutral-500">
            Belum ada postingan saat ini.
        </div>
    @endforelse
</div>
@endsection
