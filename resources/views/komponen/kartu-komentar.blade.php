<div class="rounded-2xl border border-neutral-200 bg-white p-4">
    <div class="flex flex-wrap items-center gap-2 text-sm">
        <span class="font-bold text-neutral-900">{{ $komentar['penulis'] }}</span>
        <span class="text-neutral-500">· {{ $komentar['waktu'] }}</span>
    </div>

    @if (!empty($komentar['isi']))
        <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-neutral-800">{{ $komentar['isi'] }}</p>
    @endif

    {{-- Lampiran Foto --}}
    @if (!empty($komentar['foto']))
        <div class="mt-2.5 overflow-hidden rounded-xl border border-neutral-200 bg-neutral-100">
            <img src="{{ asset($komentar['foto']) }}" alt="Foto komentar" class="max-h-72 w-full object-cover">
        </div>
    @endif

    {{-- Lampiran Video --}}
    @if (!empty($komentar['video']))
        <div class="mt-2.5 overflow-hidden rounded-xl border border-neutral-200 bg-black">
            <video src="{{ asset($komentar['video']) }}" controls class="max-h-72 w-full"></video>
        </div>
    @endif

    {{-- Lampiran Lokasi Google Maps --}}
    @if (!empty($komentar['lokasi']))
        <div class="mt-2.5">
            <a href="{{ $komentar['lokasi'] }}" target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800 transition hover:bg-emerald-100">
                <svg class="h-3.5 w-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-5.5-7-11a7 7 0 1114 0c0 5.5-7 11-7 11z" />
                    <circle cx="12" cy="10" r="2.5" />
                </svg>
                <span class="truncate max-w-[220px]">{{ $komentar['lokasi_nama'] ?? 'Lihat Lokasi di Google Maps' }}</span>
                <svg class="h-3 w-3 opacity-60 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    @endif
</div>
