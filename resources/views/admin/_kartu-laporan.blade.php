<article class="space-y-3 rounded-2xl border border-neutral-200 bg-white p-4">
    <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-neutral-500">
        <span>
            Alasan: <b class="text-rose-600">{{ $laporan->alasan }}</b>
            · oleh {{ $laporan->pelapor->name ?? 'pengguna terhapus' }}
            · {{ $laporan->created_at->diffForHumans() }}
        </span>
        <span class="rounded-full bg-neutral-100 px-2 py-0.5 font-semibold capitalize">{{ $laporan->status }}</span>
    </div>

    @if ($laporan->keterangan)
        <p class="text-sm italic text-neutral-600">"{{ $laporan->keterangan }}"</p>
    @endif

    <div class="rounded-xl bg-neutral-50 p-3">
        <p class="text-xs font-semibold text-neutral-700">{{ $laporan->post->penulis }}</p>
        <p class="mt-1 whitespace-pre-line text-sm text-neutral-900">{{ $laporan->post->konten }}</p>
        <a href="{{ route('post.show', $laporan->post->id) }}" class="mt-2 inline-block text-xs text-neutral-600 hover:underline">
            Lihat postingan →
        </a>
    </div>

    <div class="flex flex-wrap items-center gap-2 pt-1">
        @foreach (['diabaikan' => 'Abaikan', 'ditindak' => 'Tandai ditindak', 'menunggu' => 'Tinjau ulang'] as $nilai => $teks)
            @if ($laporan->status !== $nilai)
                <form method="POST" action="{{ route('admin.laporan.update', $laporan->id) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="{{ $nilai }}">
                    <button type="submit"
                        class="rounded-full border border-neutral-300 px-3 py-1 text-xs font-semibold text-neutral-700 hover:border-neutral-900">
                        {{ $teks }}
                    </button>
                </form>
            @endif
        @endforeach

        <form method="POST" action="{{ route('admin.postingan.destroy', $laporan->post->id) }}"
            onsubmit="return confirm('Hapus postingan ini secara permanen?')" class="ml-auto">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-full bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-700">
                Hapus postingan
            </button>
        </form>
    </div>
</article>