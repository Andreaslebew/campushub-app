@extends('layouts.app')

@section('content')
<div class="rounded-2xl border border-neutral-200 bg-white p-5 sm:p-6">
    <div class="mb-5 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-bold text-neutral-900">Edit Event</h1>
            <p class="mt-0.5 text-xs sm:text-sm text-neutral-500">Perbarui informasi dan jadwal event kampus.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('event.update', $event['id']) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="space-y-4">
            <div class="space-y-1.5">
                <label for="judul" class="block text-xs sm:text-sm font-semibold text-neutral-900">Judul event</label>
                <input id="judul" name="judul" type="text" value="{{ old('judul', $event['judul'] ?? '') }}" maxlength="150" required
                    placeholder="Contoh: Seminar Nasional Kecerdasan Buatan"
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                @error('judul')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="space-y-1.5">
                    <label for="penyelenggara" class="block text-xs sm:text-sm font-semibold text-neutral-900">Penyelenggara</label>
                    <input id="penyelenggara" name="penyelenggara" type="text" value="{{ old('penyelenggara', $event['penyelenggara'] ?? '') }}" maxlength="100" required
                        placeholder="Contoh: HMIF Universitas Brawijaya"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    @error('penyelenggara')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="kategori" class="block text-xs sm:text-sm font-semibold text-neutral-900">Kategori event</label>
                    <select id="kategori" name="kategori" required
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                        @foreach ($daftarKategori as $kat)
                            <option value="{{ $kat }}" @selected(old('kategori', $event['kategori'] ?? '') === $kat)>{{ $kat }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="space-y-1.5">
                    <label for="scope-event" class="block text-xs sm:text-sm font-semibold text-neutral-900">Jangkauan</label>
                    <select id="scope-event" name="scope"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                        <option value="Kota" @selected(old('scope', $event['scope'] ?? '') === 'Kota')>Event Kota</option>
                        <option value="Kampus" @selected(old('scope', $event['scope'] ?? '') === 'Kampus')>Event Kampus</option>
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label for="tanggal" class="block text-xs sm:text-sm font-semibold text-neutral-900">Tanggal pelaksanaan</label>
                    <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', $event['tanggal'] ?? '') }}" required
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    @error('tanggal')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="waktu" class="block text-xs sm:text-sm font-semibold text-neutral-900">Waktu / Jam</label>
                    <input id="waktu" name="waktu" type="text" value="{{ old('waktu', $event['waktu'] ?? '') }}" maxlength="100" required
                        placeholder="Contoh: 08.00 - 12.00 WIB"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    @error('waktu')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="space-y-1.5">
                    <label for="biaya" class="block text-xs sm:text-sm font-semibold text-neutral-900">Biaya pendaftaran</label>
                    <input id="biaya" name="biaya" type="text" value="{{ old('biaya', $event['biaya'] ?? '') }}" maxlength="50" required
                        placeholder="Contoh: Gratis atau Rp 50.000"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    @error('biaya')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="lokasi-event" class="block text-xs sm:text-sm font-semibold text-neutral-900">Lokasi / Tempat acara</label>
                    <input id="lokasi-event" name="lokasi_nama" type="text" value="{{ old('lokasi_nama', $event['lokasi'] ?? '') }}" maxlength="255"
                        placeholder="Contoh: Gedung Widyaloka UB"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    <input type="hidden" name="lokasi" value="{{ old('lokasi', $event['lokasi_url'] ?? '') }}">
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="deskripsi" class="block text-xs sm:text-sm font-semibold text-neutral-900">Deskripsi event</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" maxlength="1000" required
                    placeholder="Tuliskan detail mengenai event ini..."
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">{{ old('deskripsi', $event['deskripsi'] ?? '') }}</textarea>
                @error('deskripsi')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Preview Media Saat Ini --}}
            @if (!empty($event['foto']))
                <div class="space-y-1.5">
                    <span class="block text-xs font-semibold text-neutral-700">Poster / Foto saat ini:</span>
                    <div class="preview-media-box">
                        <img src="{{ asset($event['foto']) }}" alt="Foto event" class="h-32 rounded-xl object-cover">
                    </div>
                </div>
            @endif

            @if (!empty($event['video']))
                <div class="space-y-1.5">
                    <span class="block text-xs font-semibold text-neutral-700">Video saat ini:</span>
                    <div class="preview-media-box">
                        <video src="{{ asset($event['video']) }}" controls class="h-32 rounded-xl"></video>
                    </div>
                </div>
            @endif

            {{-- Ganti Foto / Video --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 pt-2">
                <div class="space-y-1.5">
                    <label for="input-foto-event" class="block text-xs font-semibold text-neutral-700">Ganti Poster / Foto (opsional)</label>
                    <input type="file" id="input-foto-event" name="foto" accept="image/*"
                        class="block w-full text-xs text-neutral-500 file:mr-3 file:rounded-full file:border-0 file:bg-neutral-100 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-neutral-700 hover:file:bg-neutral-200">
                </div>

                <div class="space-y-1.5">
                    <label for="input-video-event" class="block text-xs font-semibold text-neutral-700">Ganti Video (opsional)</label>
                    <input type="file" id="input-video-event" name="video" accept="video/*"
                        class="block w-full text-xs text-neutral-500 file:mr-3 file:rounded-full file:border-0 file:bg-neutral-100 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-neutral-700 hover:file:bg-neutral-200">
                </div>
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
