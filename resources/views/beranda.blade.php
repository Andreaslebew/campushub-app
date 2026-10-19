@extends('layouts.app')

@section('content')
<div class="space-y-4">

    <!-- Bar pencarian & filter -->
    <form method="GET" action="{{ url('/') }}" class="flex flex-wrap items-center gap-2">
        <label class="flex min-w-[12rem] flex-1 items-center gap-2 rounded-full border border-neutral-300 bg-white px-4 py-2.5 transition focus-within:border-neutral-900">
            <svg class="h-4 w-4 shrink-0 text-neutral-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2M16.5 10.5a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
            <input type="search" name="q" value="{{ request('q') }}"
                placeholder="Cari postingan, topik, atau mahasiswa..."
                class="w-full border-0 bg-transparent p-0 text-sm placeholder:text-neutral-400 focus:ring-0">
        </label>

        <select name="prodi" onchange="this.form.submit()"
            class="rounded-full border border-neutral-300 bg-white px-4 py-2.5 text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
            <option value="">Filter Prodi</option>
            @foreach ($daftarProdi ?? [] as $prodi)
                <option value="{{ $prodi }}" @selected(request('prodi') === $prodi)>{{ $prodi }}</option>
            @endforeach
        </select>

        @php $urut = request('urut', 'teramai'); @endphp

        <button type="submit" name="urut" value="teramai"
            class="rounded-full border px-4 py-2.5 text-sm font-medium transition
            {{ $urut === 'teramai' ? 'border-neutral-900 bg-neutral-900 text-white' : 'border-neutral-300 bg-white text-neutral-900 hover:border-neutral-900' }}">
            Teramai
        </button>

        <button type="submit" name="urut" value="terbaru"
            class="rounded-full border px-4 py-2.5 text-sm font-medium transition
            {{ $urut === 'terbaru' ? 'border-neutral-900 bg-neutral-900 text-white' : 'border-neutral-300 bg-white text-neutral-900 hover:border-neutral-900' }}">
            Terbaru
        </button>
    </form>

    <!-- Daftar postingan -->
    <div class="space-y-3">
        @forelse ($posts as $p)
            @include('komponen.kartu-post', ['post' => $p])
        @empty
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-8 text-center text-sm text-neutral-500">
                Belum ada postingan saat ini.
            </div>
        @endforelse
    </div>
</div>
@endsection