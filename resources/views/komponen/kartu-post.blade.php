@php
    $inisial = mb_strtoupper(mb_substr($post['penulis'] ?? 'U', 0, 1));
    $isKampus = in_array(strtolower($post['scope'] ?? ''), ['kampus']);
    $sudahSuka = in_array($post['id'], session('disukai', []), true);
@endphp

<article id="post-{{ $post['id'] }}" class="scroll-mt-24 rounded-2xl border border-neutral-200 bg-white p-4 sm:p-5 transition hover:bg-neutral-50/60">
    <div class="flex items-start justify-between gap-3">
        <div class="flex min-w-0 items-center gap-3">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-neutral-200 text-sm font-bold text-neutral-600">
                {{ $inisial }}
            </div>

            <div class="min-w-0">
                <h6 class="truncate text-[15px] font-bold leading-tight text-neutral-900">{{ $post['penulis'] }}</h6>
                <p class="truncate text-sm text-neutral-500">
                    {{ $post['kampus'] }}
                    @if (!empty($post['waktu']))
                        · {{ $post['waktu'] }}
                    @endif
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            @if ($bisaEdit ?? false)
                <a href="{{ route('post.edit', $post['id']) }}"
                    class="inline-flex items-center gap-1 rounded-full border border-neutral-300 bg-white px-2.5 py-1 text-xs font-semibold text-neutral-700 transition hover:border-neutral-900 hover:bg-neutral-900 hover:text-white">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    <span>Edit</span>
                </a>
            @endif

            <span class="rounded-full border px-3 py-0.5 text-xs font-semibold
                {{ $isKampus ? 'border-neutral-900 text-neutral-900' : 'border-neutral-300 text-neutral-600' }}">
                {{ $isKampus ? 'Kampus' : 'Kota' }}
            </span>
        </div>
    </div>

    <p class="mt-3 text-[15px] leading-relaxed text-neutral-900 whitespace-pre-line">{{ $post['konten'] }}</p>

    {{-- Lampiran Foto --}}
    @if (!empty($post['foto']))
        <div class="mt-3 overflow-hidden rounded-xl border border-neutral-200 bg-neutral-100">
            <img src="{{ asset($post['foto']) }}" alt="Foto postingan" class="max-h-96 w-full object-cover">
        </div>
    @endif

    {{-- Lampiran Video --}}
    @if (!empty($post['video']))
        <div class="mt-3 overflow-hidden rounded-xl border border-neutral-200 bg-black">
            <video src="{{ asset($post['video']) }}" controls class="max-h-96 w-full"></video>
        </div>
    @endif

    {{-- Lampiran Lokasi Google Maps --}}
    @if (!empty($post['lokasi']))
        <div class="mt-3">
            <a href="{{ $post['lokasi'] }}" target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800 transition hover:bg-emerald-100">
                <svg class="h-3.5 w-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-5.5-7-11a7 7 0 1114 0c0 5.5-7 11-7 11z" />
                    <circle cx="12" cy="10" r="2.5" />
                </svg>
                <span class="truncate max-w-[260px]">{{ $post['lokasi_nama'] ?? 'Lihat Lokasi di Google Maps' }}</span>
                <svg class="h-3 w-3 opacity-60 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    @endif

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-4">
            <span class="rounded-md bg-neutral-100 px-2 py-1 text-xs text-neutral-600">
                Prodi: {{ $post['prodi'] }}
            </span>

            @auth
                <form method="POST" action="{{ route('post.suka', $post['id']) }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-1.5 text-sm transition {{ $sudahSuka ? 'text-rose-600' : 'text-neutral-500 hover:text-rose-600' }}">
                        <svg class="h-[18px] w-[18px]" fill="{{ $sudahSuka ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.49-2.02-4.5-4.5-4.5-1.74 0-3.25 1-4 2.46C12.75 4.75 11.24 3.75 9.5 3.75 7.02 3.75 5 5.76 5 8.25c0 4.5 7 11.25 7 11.25s7-6.75 7-11.25z" />
                        </svg>
                        <span>{{ $post['suka'] ?? 0 }}</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-1.5 text-sm text-neutral-500 hover:text-rose-600">
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.49-2.02-4.5-4.5-4.5-1.74 0-3.25 1-4 2.46C12.75 4.75 11.24 3.75 9.5 3.75 7.02 3.75 5 5.76 5 8.25c0 4.5 7 11.25 7 11.25s7-6.75 7-11.25z" />
                    </svg>
                    <span>{{ $post['suka'] ?? 0 }}</span>
                </a>
            @endauth

            <span class="text-sm text-neutral-500">{{ $post['komentar'] ?? 0 }} balasan</span>
        </div>

        <a href="{{ route('post.show', ['id' => $post['id'], 'from' => request()->getRequestUri()]) }}"
            class="rounded-full border border-neutral-300 px-4 py-1.5 text-sm font-medium text-neutral-900 transition hover:bg-neutral-900 hover:text-white">
            Komentar
        </a>
    </div>
</article>
