<div class="rounded-2xl border border-neutral-200 bg-white p-4">
    <div class="flex flex-wrap items-center gap-2 text-sm">
        <span class="font-bold text-neutral-900">{{ $komentar['penulis'] }}</span>
        <span class="text-neutral-500">· {{ $komentar['waktu'] }}</span>
    </div>
    <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-neutral-800">{{ $komentar['isi'] }}</p>
</div>