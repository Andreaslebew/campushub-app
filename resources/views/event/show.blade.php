@extends('layouts.app')

@section('content')
<div class="space-y-4">

    <a href="{{ route('event') }}" class="inline-flex text-sm text-neutral-600 hover:text-neutral-900 hover:underline">
        &larr; Kembali ke daftar event
    </a>

    {{-- Kartu event utama --}}
    @include('komponen.kartu-event', ['event' => $event])

    @if (session('sukses'))
        <div class="rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('sukses') }}
        </div>
    @endif

    {{-- Form komentar --}}
    <form method="POST" action="{{ route('event.komentar', $event['id']) }}"
        class="rounded-2xl border border-neutral-200 bg-white p-4">
        @csrf

        <label for="isi" class="text-sm font-semibold text-neutral-900">Tulis komentar</label>
        <textarea id="isi" name="isi" rows="3" maxlength="500"
            placeholder="Tanyakan sesuatu tentang event ini..."
            class="mt-2 w-full rounded-xl border-neutral-300 text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">{{ old('isi') }}</textarea>

        @error('isi')
            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
        @enderror

        <div class="mt-3 flex justify-end">
            <button type="submit"
                class="rounded-full bg-neutral-900 px-5 py-1.5 text-sm font-semibold text-white hover:bg-neutral-700">
                Kirim
            </button>
        </div>
    </form>

    {{-- Daftar komentar --}}
    <div class="space-y-3">
        <h2 class="text-sm font-bold text-neutral-900">{{ count($komentar) }} komentar</h2>

        @forelse ($komentar as $k)
            @include('komponen.kartu-komentar', ['komentar' => $k])
        @empty
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-6 text-center text-sm text-neutral-500">
                Belum ada komentar. Jadilah yang pertama bertanya.
            </div>
        @endforelse
    </div>
</div>
@endsection