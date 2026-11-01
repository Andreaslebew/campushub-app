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
            <div class="space-y-1.5">
                <label for="kampus" class="block text-xs sm:text-sm font-semibold text-neutral-900">Nama kampus</label>
                <input id="kampus" name="kampus" type="text" value="{{ old('kampus', $post['kampus'] ?? '') }}" maxlength="100"
                    placeholder="Contoh: Universitas Brawijaya" required
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                @error('kampus')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="space-y-1.5">
                    <label for="scope-post" class="block text-xs sm:text-sm font-semibold text-neutral-900">Forum</label>
                    <select id="scope-post" name="scope"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                        <option value="Kota" @selected(old('scope', $post['scope'] ?? '') === 'Kota')>Forum Kota</option>
                        <option value="Kampus" @selected(old('scope', $post['scope'] ?? '') === 'Kampus')>Forum Kampus</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label for="prodi" class="block text-xs sm:text-sm font-semibold text-neutral-900">Prodi</label>
                    <select id="prodi" name="prodi" required
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                        <option value="">Pilih prodi</option>
                        @foreach ($daftarProdi as $prodi)
                            <option value="{{ $prodi }}" @selected(old('prodi', $post['prodi'] ?? '') === $prodi)>{{ $prodi }}</option>
                        @endforeach
                    </select>
                    @error('prodi')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
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
                        <video src="{{ asset($post['video']) }}" controls class="h-32 rounded-xl"></video>
                    </div>
                </div>
            @endif

            {{-- Ganti Foto / Video --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 pt-2">
                <div class="space-y-1.5">
                    <label for="input-foto" class="block text-xs font-semibold text-neutral-700">Ganti Foto (opsional)</label>
                    <input type="file" id="input-foto" name="foto" accept="image/*"
                        class="block w-full text-xs text-neutral-500 file:mr-3 file:rounded-full file:border-0 file:bg-neutral-100 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-neutral-700 hover:file:bg-neutral-200">
                </div>

                <div class="space-y-1.5">
                    <label for="input-video" class="block text-xs font-semibold text-neutral-700">Ganti Video (opsional)</label>
                    <input type="file" id="input-video" name="video" accept="video/*"
                        class="block w-full text-xs text-neutral-500 file:mr-3 file:rounded-full file:border-0 file:bg-neutral-100 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-neutral-700 hover:file:bg-neutral-200">
                </div>
            </div>

            {{-- Lokasi --}}
            <div class="space-y-1.5 pt-2">
                <label for="input-lokasi-nama" class="block text-xs sm:text-sm font-semibold text-neutral-900">Lokasi Tempat (opsional)</label>
                <input type="text" id="input-lokasi-nama" name="lokasi_nama"
                    value="{{ old('lokasi_nama', $post['lokasi_nama'] ?? '') }}"
                    placeholder="Contoh: Gedung Teknik Informatika, Malang"
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                <input type="hidden" name="lokasi" value="{{ old('lokasi', $post['lokasi'] ?? '') }}">
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 border-t border-neutral-100 pt-4">
            <a href="{{ route('akun.index', ['tab' => 'postingan']) }}"
                class="rounded-full px-5 py-2 text-xs sm:text-sm font-medium text-neutral-600 hover:bg-neutral-100">
                Batal
            </a>
            <button type="submit"
                class="rounded-full bg-neutral-900 px-6 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-neutral-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
