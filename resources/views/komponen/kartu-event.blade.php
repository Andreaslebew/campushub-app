@php
    $inisial = mb_strtoupper(mb_substr($event['penyelenggara'] ?? 'E', 0, 1));
    $isKampus = ($event['scope'] ?? '') === 'Kampus';
    $tanggal = \Carbon\Carbon::parse($event['tanggal'])->locale('id')->translatedFormat('l, d F Y');
@endphp

<article class="rounded-2xl border border-neutral-200 bg-white p-4 sm:p-5 transition hover:bg-neutral-50/60">
    <div class="flex items-start justify-between gap-3">
        <div class="flex min-w-0 items-center gap-3">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-neutral-200 text-sm font-bold text-neutral-600">
                {{ $inisial }}
            </div>

            <div class="min-w-0">
                <h6 class="truncate text-[15px] font-bold leading-tight text-neutral-900">{{ $event['penyelenggara'] }}</h6>
                <p class="truncate text-sm text-neutral-500">Event · {{ $tanggal }}</p>
            </div>
        </div>

        <span class="shrink-0 rounded-full border px-3 py-0.5 text-xs font-semibold
            {{ $isKampus ? 'border-neutral-900 text-neutral-900' : 'border-neutral-300 text-neutral-600' }}">
            {{ $isKampus ? 'Kampus' : 'Kota' }}
        </span>
    </div>

    <h3 class="mt-3 text-[15px] font-bold leading-snug text-neutral-900">{{ $event['judul'] }}</h3>

    <div class="mt-2 space-y-1 text-sm text-neutral-700">
        <p>🕒 {{ $event['waktu'] }}</p>
        <p>📍 {{ $event['lokasi'] }}</p>
    </div>

    <p class="mt-3 text-[15px] leading-relaxed text-neutral-900">{{ $event['deskripsi'] }}</p>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap items-center gap-4">
            <span class="rounded-md bg-neutral-100 px-2 py-1 text-xs text-neutral-600">{{ $event['kategori'] }}</span>
            <span class="text-sm text-neutral-500">{{ $event['biaya'] }}</span>
        </div>

        <a href="{{ route('event.show', $event['id']) }}"
            class="rounded-full border border-neutral-300 px-4 py-1.5 text-sm font-medium text-neutral-900 transition hover:bg-neutral-900 hover:text-white">
            Komentar
        </a>
    </div>
</article>