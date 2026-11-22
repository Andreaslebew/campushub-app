@extends('layouts.app')

@section('content')
<div class="rounded-2xl border border-neutral-200 bg-white p-5 sm:p-6">
    <div class="mb-5 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-bold text-neutral-900">Edit Postingan</h1>
            <p class="mt-0.5 text-xs sm:text-sm text-neutral-500">Perbarui isi atau detail postinganmu.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs sm:text-sm text-rose-700">
            <p class="font-semibold">Ada isian yang belum sesuai:</p>
            <ul class="mt-1 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0 @error('scope') is-invalid @enderror">
                    <option value="Kota" @selected(old('scope', $post['scope'] ?? '') === 'Kota')>Forum Kota</option>
                    <option value="Kampus" @selected(old('scope', $post['scope'] ?? '') === 'Kampus')>Forum Kampus</option>
                </select>
                @error('scope')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <label for="konten" class="block text-xs sm:text-sm font-semibold text-neutral-900">Isi postingan</label>
                <textarea id="konten" name="konten" rows="4" maxlength="500"
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0 @error('konten') is-invalid @enderror">{{ old('konten', $post['konten'] ?? '') }}</textarea>
                @error('konten')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Foto saat ini --}}
            @if (!empty($post['foto']))
                <div class="space-y-1.5">
                    <span class="block text-xs font-semibold text-neutral-700">Foto saat ini:</span>
                    <div class="preview-media-box">
                        <img src="{{ asset($post['foto']) }}" alt="Foto postingan" class="h-32 rounded-xl object-cover">
                    </div>
                </div>
            @endif

            {{-- Video saat ini --}}
            @if (!empty($post['video']))
                <div class="space-y-1.5">
                    <span class="block text-xs font-semibold text-neutral-700">Video saat ini:</span>
                    <div class="preview-media-box bg-black">
                        <video src="{{ asset($post['video']) }}" controls class="h-32 max-w-xs"></video>
                    </div>
                </div>
            @endif

            {{-- Ganti foto --}}
            <div class="space-y-1.5">
                <span class="block text-xs sm:text-sm font-semibold text-neutral-900">Ganti foto (opsional)</span>
                <label for="input-foto"
                    class="flex cursor-pointer items-center gap-3 rounded-xl border border-dashed border-neutral-400 bg-white px-4 py-3 text-xs sm:text-sm text-neutral-700 hover:border-neutral-900 hover:bg-neutral-50">
                    <span class="shrink-0 rounded-full bg-neutral-900 px-3 py-1.5 text-xs font-semibold text-white">Pilih foto</span>
                    <span id="nama-foto" class="truncate text-neutral-500">Belum ada foto dipilih</span>
                </label>
                <input id="input-foto" type="file" name="foto" accept="image/*" class="sr-only"
                    onchange="document.getElementById('nama-foto').textContent = this.files.length ? this.files[0].name : 'Belum ada foto dipilih'">
                @error('foto')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Ganti video --}}
            <div class="space-y-1.5">
                <span class="block text-xs sm:text-sm font-semibold text-neutral-900">Ganti video (opsional)</span>
                <label for="input-video"
                    class="flex cursor-pointer items-center gap-3 rounded-xl border border-dashed border-neutral-400 bg-white px-4 py-3 text-xs sm:text-sm text-neutral-700 hover:border-neutral-900 hover:bg-neutral-50">
                    <span class="shrink-0 rounded-full bg-neutral-900 px-3 py-1.5 text-xs font-semibold text-white">Pilih video</span>
                    <span id="nama-video" class="truncate text-neutral-500">Belum ada video dipilih</span>
                </label>
                <input id="input-video" type="file" name="video" accept="video/*" class="sr-only"
                    onchange="document.getElementById('nama-video').textContent = this.files.length ? this.files[0].name : 'Belum ada video dipilih'">
                @error('video')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- Lokasi --}}
            <div class="space-y-1.5">
                <label for="lokasi_nama" class="block text-xs sm:text-sm font-semibold text-neutral-900">Lokasi (opsional)</label>
                <input id="lokasi_nama" type="text" name="lokasi_nama" maxlength="255"
                    value="{{ old('lokasi_nama', $post['lokasi_nama'] ?? '') }}"
                    placeholder="Contoh: Gedung Teknik Informatika, Malang"
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">
                @error('lokasi_nama')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3">
            <a href="{{ url('/') }}"
                class="rounded-full px-4 py-2 text-xs sm:text-sm font-medium text-neutral-600 hover:bg-neutral-100">Batal</a>
            <button type="submit"
                class="rounded-full bg-neutral-900 px-6 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-neutral-700">
                Simpan perubahan
            </button>
        </div>
    </form>
</div>
@endsection