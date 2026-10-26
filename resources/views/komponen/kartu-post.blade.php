@php
    $inisial = mb_strtoupper(mb_substr($post['penulis'] ?? 'U', 0, 1));
    $isKampus = in_array(strtolower($post['scope'] ?? ''), ['kampus']);
    $sudahSuka = in_array($post['id'], session('disukai', []), true);
@endphp

<article class="rounded-2xl border border-neutral-200 bg-white p-4 sm:p-5 transition hover:bg-neutral-50/60">
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

        <span class="shrink-0 rounded-full border px-3 py-0.5 text-xs font-semibold
            {{ $isKampus ? 'border-neutral-900 text-neutral-900' : 'border-neutral-300 text-neutral-600' }}">
            {{ $isKampus ? 'Kampus' : 'Kota' }}
        </span>
    </div>

    <p class="mt-3 text-[15px] leading-relaxed text-neutral-900 whitespace-pre-line">{{ $post['konten'] }}</p>

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

        <a href="{{ route('post.show', $post['id']) }}"
            class="rounded-full border border-neutral-300 px-4 py-1.5 text-sm font-medium text-neutral-900 transition hover:bg-neutral-900 hover:text-white">
            Komentar
        </a>
    </div>
</article>