@extends('layouts.app')

@section('content')
<div class="space-y-4">

    <!-- Bar pencarian & filter -->
    <form method="GET" action="{{ url()->current() }}" class="space-y-2">
        <label class="flex w-full items-center gap-2 rounded-full border border-neutral-300 bg-white px-4 py-2.5 focus-within:border-neutral-900">
            <svg class="h-4 w-4 shrink-0 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
            <input type="search" name="q" value="{{ request('q') }}"
                placeholder="Cari postingan, topik, atau mahasiswa..."
                class="w-full border-0 bg-transparent p-0 text-sm placeholder:text-neutral-400 focus:ring-0">
        </label>

        <div class="flex items-center gap-2">
            <select name="prodi" onchange="this.form.submit()"
                class="min-w-0 flex-1 rounded-full border border-neutral-300 bg-white px-4 py-2 text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
                <option value="">Filter Prodi</option>
                @foreach ($daftarProdi ?? [] as $prodi)
                    <option value="{{ $prodi }}" @selected(request('prodi') === $prodi)>{{ $prodi }}</option>
                @endforeach
            </select>

            @php $urut = request('urut', 'teramai'); @endphp

            <button type="submit" name="urut" value="teramai"
                class="shrink-0 rounded-full border px-4 py-2 text-sm font-medium transition
                {{ $urut === 'teramai' ? 'border-neutral-900 bg-neutral-900 text-white' : 'border-neutral-300 bg-white text-neutral-900 hover:border-neutral-900' }}">
                Teramai
            </button>

            <button type="submit" name="urut" value="terbaru"
                class="shrink-0 rounded-full border px-4 py-2 text-sm font-medium transition
                {{ $urut === 'terbaru' ? 'border-neutral-900 bg-neutral-900 text-white' : 'border-neutral-300 bg-white text-neutral-900 hover:border-neutral-900' }}">
                Terbaru
            </button>
        </div>
    </form>

    <!-- Daftar postingan dan event -->
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
</div>
@endsection