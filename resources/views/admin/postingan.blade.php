@extends('layouts.app')

@section('content')
<div class="space-y-5">
    <h1 class="text-xl font-bold text-neutral-900">Panel Admin</h1>
    @include('admin._menu')

    <form method="GET" action="{{ route('admin.postingan') }}">
        <input type="search" name="q" value="{{ $q }}" placeholder="Cari isi atau nama penulis..."
            class="w-full rounded-xl border-neutral-300 text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">
    </form>

    <div class="space-y-3">
        @forelse ($posts as $post)
            <article class="flex items-start justify-between gap-3 rounded-2xl border border-neutral-200 bg-white p-4">
                <div class="min-w-0">
                    <p class="text-sm font-bold text-neutral-900">
                        {{ $post->penulis }}
                        <span class="font-normal text-neutral-500">· {{ $post->kampus ?? '-' }} · {{ $post->created_at->diffForHumans() }}</span>
                    </p>
                    <p class="mt-1 whitespace-pre-line text-sm text-neutral-800">{{ $post->konten }}</p>
                    <p class="mt-2 text-xs text-neutral-500">
                        {{ $post->laporan_count }} laporan ·
                        <a href="{{ route('post.show', $post->id) }}" class="hover:underline">Buka postingan</a>
                    </p>
                </div>

                <form method="POST" action="{{ route('admin.postingan.destroy', $post->id) }}"
                    onsubmit="return confirm('Hapus postingan ini secara permanen?')" class="shrink-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-full border border-rose-200 px-3 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-600 hover:text-white">
                        Hapus
                    </button>
                </form>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-6 text-center text-sm text-neutral-500">
                Postingan tidak ditemukan.
            </div>
        @endforelse
    </div>

    {{ $posts->links() }}
</div>
@endsection