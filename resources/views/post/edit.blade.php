@extends('layouts.app')

@section('content')
<div class="rounded-2xl border border-neutral-200 bg-white p-5 sm:p-6">
    <div class="mb-5 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-bold text-neutral-900">Edit Postingan</h1>
            <p class="mt-0.5 text-xs sm:text-sm text-neutral-500">Perbarui isi atau detail postinganmu.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('post.update', $post['id']) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div class="rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-xs sm:text-sm text-neutral-600">
                Diposting sebagai <span class="font-semibold text-neutral-900">{{ auth()->user()->prodi ?? '-' }}</span>
                · {{ auth()->user()->kampus ?? '-' }} · {{ auth()->user()->kota ?? '-' }}
            </div>

            <div class="space-y-1.5">
                <label for="scope-post" class="block text-xs sm:text-sm font-semibold text-neutral-900">Forum</label>
                <select id="scope-post" name="scope"
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    <option value="Kota" @selected(old('scope', $post['scope'] ?? '') === 'Kota')>Forum Kota</option>
                    <option value="Kampus" @selected(old('scope', $post['scope'] ?? '') === 'Kampus')>Forum Kampus</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label for="konten" class="block text-xs sm:text-sm font-semibold text-neutral-900">Isi postingan</label>
                <textarea id="konten" name="konten" rows="4" maxlength="500" required
                    placeholder="Apa yang ingin kamu diskusikan atau tanyakan?"
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">{{ old('konten', $post['konten'] ?? '') }}</textarea>
                @error('konten')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Preview Media Saat Ini --}}
            @if (!empty($post['foto']))
                <div class="space-y-1.5">
                    <span class="block text-xs font-semibold text-neutral-700">Foto saat ini:</span>
                    <div class="preview-media-box">
                        <img src="{{ asset($post['foto']) }}" alt="Foto postingan" class="h-32 rounded-xl object-cover">
                    </div>
                </div>
            @endif

            @if (!empty($post['video']))
                <div class="space-y-1.5">
                    <span class="block text-xs font-semibold text-neutral-700">Video saat ini:</span>
                    <div class="preview-media-box">
            @endif