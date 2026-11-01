@extends('layouts.app')

@section('content')
<div class="space-y-4">

    @php
        $asal = request('from');
        if (! $asal || $asal === url()->current()) {
            $asal = url()->previous();
        }
        if (! $asal || $asal === url()->current()) {
            $asal = url('/');
        }
        if (! str_contains($asal, '#')) {
            $asal .= '#post-'.$post['id'];
        }
    @endphp

    <a href="{{ $asal }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-neutral-600 hover:text-neutral-900 hover:underline">
        &larr; Kembali
    </a>

    {{-- Postingan utama --}}
    @include('komponen.kartu-post', ['post' => $post])

    {{-- Notifikasi sukses --}}
    @if (session('sukses'))
        <div class="rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('sukses') }}
        </div>
    @endif

    {{-- Form balasan --}}
    <form method="POST" action="{{ route('post.komentar', $post['id']) }}" enctype="multipart/form-data"
        class="rounded-2xl border border-neutral-200 bg-white p-4">
        @csrf
        @if (request('from'))
            <input type="hidden" name="from" value="{{ request('from') }}">
        @endif

        <label for="isi" class="text-sm font-semibold text-neutral-900">Tulis balasan</label>
        <textarea id="isi" name="isi" rows="3" maxlength="500"
            placeholder="Bagikan pengalamanmu..."
            class="mt-2 w-full rounded-xl border-neutral-300 text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">{{ old('isi') }}</textarea>

        @error('isi')
            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
        @enderror

        {{-- Area Previews Lampiran Komentar --}}
        <div class="space-y-2 pt-2">
            {{-- Preview Foto --}}
            <div id="c-preview-foto-wrap" class="is-hidden">
                <div class="preview-media-box">
                    <img id="c-preview-foto-img" src="" alt="" class="h-24 w-24 object-cover">
                    <button type="button" id="c-btn-hapus-foto" class="preview-media-delete-btn" title="Hapus foto">
                        &times;
                    </button>
                </div>
            </div>

            {{-- Preview Video --}}
            <div id="c-preview-video-wrap" class="is-hidden">
                <div class="preview-media-box bg-black">
                    <video id="c-preview-video-tag" controls class="h-28 max-w-xs"></video>
                    <button type="button" id="c-btn-hapus-video" class="preview-media-delete-btn" title="Hapus video">
                        &times;
                    </button>
                </div>
            </div>

            {{-- Preview Lokasi Terpilih --}}
            <div id="c-preview-lokasi-wrap" class="is-hidden">
                <span class="chip-lokasi">
                    <svg class="h-3.5 w-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-5.5-7-11a7 7 0 1114 0c0 5.5-7 11-7 11z" />
                        <circle cx="12" cy="10" r="2.5" />
                    </svg>
                    <span id="c-preview-lokasi-text" class="truncate max-w-[200px]"></span>
                    <button type="button" id="c-btn-hapus-lokasi" class="ml-1 text-emerald-700 hover:text-rose-600 font-bold" title="Hapus lokasi">&times;</button>
                </span>
            </div>

            {{-- Panel Pilihan Lokasi Google Maps --}}
            <div id="c-panel-lokasi" class="is-hidden attachment-panel space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-neutral-800 flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        Bagikan Lokasi
                    </span>
                    <button type="button" id="c-btn-tutup-lokasi" class="text-xs text-neutral-400 hover:text-neutral-700">&times; Tutup</button>
                </div>

                {{-- Opsi 1: Gunakan Lokasi Saat Ini (GPS) --}}
                <button type="button" id="c-btn-gps" class="w-full flex items-center justify-center gap-2 rounded-xl bg-white border border-neutral-300 py-2 px-3 text-xs font-semibold text-neutral-800 hover:border-neutral-900 hover:bg-neutral-100 transition shadow-sm">
                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" />
                        <path stroke-linecap="round" d="M12 2v3m0 14v3M2 12h3m14 0h3" />
                    </svg>
                    <span id="c-gps-status">Gunakan Lokasi Saat Ini (GPS)</span>
                </button>

                <div class="relative flex items-center justify-center">
                    <span class="h-px w-full bg-neutral-200"></span>
                    <span class="absolute bg-neutral-50 px-2 text-[10px] text-neutral-400 uppercase tracking-wider">atau</span>
                </div>

                {{-- Opsi 2: Cari / Ketik Nama Tempat --}}
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-semibold text-neutral-600">Pilih tempat atau kampus</label>
                        <a href="https://www.google.com/maps" target="_blank" rel="noopener noreferrer" class="text-[11px] text-blue-600 hover:underline inline-flex items-center gap-0.5">
                            Buka Google Maps
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                    <div class="flex gap-2">
                        <input type="text" id="c-input-lokasi-nama" name="lokasi_nama"
                            placeholder="Contoh: Gedung Filkom UB, Malang"
                            class="min-w-0 flex-1 rounded-xl border-neutral-300 bg-white text-xs placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">
                        <button type="button" id="c-btn-simpan-lokasi"
                            class="shrink-0 rounded-xl bg-neutral-900 px-3.5 py-1.5 text-xs font-semibold text-white hover:bg-neutral-700">
                            Pilih
                        </button>
                    </div>
                </div>

                <input type="hidden" id="c-input-lokasi-url" name="lokasi" value="">
            </div>
        </div>

        {{-- Toolbar Lampiran (Hanya Icon Saja) & Tombol Submit --}}
        <div class="mt-3 flex items-center justify-between border-t border-neutral-100 pt-2.5">
            <div class="flex items-center gap-1">
                <button type="button" id="c-btn-pilih-foto" class="toolbar-icon-btn btn-foto" title="Tambah Foto">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </button>
                <input type="file" id="c-input-foto" name="foto" accept="image/*" class="hidden">

                <button type="button" id="c-btn-pilih-video" class="toolbar-icon-btn btn-video" title="Tambah Video">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </button>
                <input type="file" id="c-input-video" name="video" accept="video/*" class="hidden">

                <button type="button" id="c-btn-buka-lokasi" class="toolbar-icon-btn btn-lokasi" title="Tambah Lokasi Google Maps">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                </button>
            </div>

            <button type="submit"
                class="rounded-full bg-neutral-900 px-5 py-1.5 text-sm font-semibold text-white hover:bg-neutral-700">
                Balas
            </button>
        </div>
    </form>

    {{-- Daftar balasan --}}
    <div class="space-y-3">
        <h2 class="text-sm font-bold text-neutral-900">{{ count($komentar) }} balasan</h2>

        @forelse ($komentar as $k)
            @include('komponen.kartu-komentar', ['komentar' => $k])
        @empty
            <div class="rounded-2xl border border-dashed border-neutral-300 bg-white p-6 text-center text-sm text-neutral-500">
                Belum ada balasan. Jadilah yang pertama membalas.
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Foto
        const btnFoto = document.getElementById('c-btn-pilih-foto');
        const inputFoto = document.getElementById('c-input-foto');
        const wrapFoto = document.getElementById('c-preview-foto-wrap');
        const imgFoto = document.getElementById('c-preview-foto-img');
        const btnHapusFoto = document.getElementById('c-btn-hapus-foto');

        btnFoto.addEventListener('click', () => inputFoto.click());
        inputFoto.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    imgFoto.src = e.target.result;
                    wrapFoto.classList.remove('is-hidden');
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
        btnHapusFoto.addEventListener('click', function () {
            inputFoto.value = '';
            imgFoto.src = '';
            wrapFoto.classList.add('is-hidden');
        });

        // Video
        const btnVideo = document.getElementById('c-btn-pilih-video');
        const inputVideo = document.getElementById('c-input-video');
        const wrapVideo = document.getElementById('c-preview-video-wrap');
        const tagVideo = document.getElementById('c-preview-video-tag');
        const btnHapusVideo = document.getElementById('c-btn-hapus-video');

        btnVideo.addEventListener('click', () => inputVideo.click());
        inputVideo.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const url = URL.createObjectURL(this.files[0]);
                tagVideo.src = url;
                wrapVideo.classList.remove('is-hidden');
            }
        });
        btnHapusVideo.addEventListener('click', function () {
            inputVideo.value = '';
            tagVideo.src = '';
            wrapVideo.classList.add('is-hidden');
        });

        // Lokasi
        const btnBukaLokasi = document.getElementById('c-btn-buka-lokasi');
        const btnTutupLokasi = document.getElementById('c-btn-tutup-lokasi');
        const panelLokasi = document.getElementById('c-panel-lokasi');
        const inputNama = document.getElementById('c-input-lokasi-nama');
        const inputUrl = document.getElementById('c-input-lokasi-url');
        const btnSimpanLokasi = document.getElementById('c-btn-simpan-lokasi');
        const wrapLokasi = document.getElementById('c-preview-lokasi-wrap');
        const textLokasi = document.getElementById('c-preview-lokasi-text');
        const btnHapusLokasi = document.getElementById('c-btn-hapus-lokasi');
        const btnGps = document.getElementById('c-btn-gps');
        const gpsStatus = document.getElementById('c-gps-status');

        btnBukaLokasi.addEventListener('click', function () {
            panelLokasi.classList.toggle('is-hidden');
        });
        btnTutupLokasi.addEventListener('click', function () {
            panelLokasi.classList.add('is-hidden');
        });

        btnGps.addEventListener('click', function () {
            if (!navigator.geolocation) {
                alert('Fitur lokasi GPS tidak didukung oleh browser Anda.');
                return;
            }
            gpsStatus.textContent = 'Mendeteksi lokasi saat ini...';
            navigator.geolocation.getCurrentPosition(
                function (pos) {
                    const lat = pos.coords.latitude.toFixed(6);
                    const lng = pos.coords.longitude.toFixed(6);
                    inputUrl.value = `https://www.google.com/maps?q=${lat},${lng}`;
                    inputNama.value = `Lokasi Saat Ini (${lat}, ${lng})`;
                    textLokasi.textContent = 'Lokasi Saat Ini (GPS)';
                    wrapLokasi.classList.remove('is-hidden');
                    panelLokasi.classList.add('is-hidden');
                    gpsStatus.textContent = 'Gunakan Lokasi Saat Ini (GPS)';
                },
                function (err) {
                    gpsStatus.textContent = 'Gunakan Lokasi Saat Ini (GPS)';
                    alert('Tidak dapat mendeteksi lokasi: ' + err.message + '. Silakan pilih atau ketik nama tempat di bawah.');
                },
                { enableHighAccuracy: true, timeout: 8000 }
            );
        });

        btnSimpanLokasi.addEventListener('click', function () {
            const valNama = inputNama.value.trim();
            if (!valNama) {
                alert('Silakan ketik nama tempat atau kampus terlebih dahulu.');
                return;
            }
            inputUrl.value = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(valNama)}`;
            textLokasi.textContent = valNama;
            wrapLokasi.classList.remove('is-hidden');
            panelLokasi.classList.add('is-hidden');
        });

        btnHapusLokasi.addEventListener('click', function () {
            inputNama.value = '';
            inputUrl.value = '';
            wrapLokasi.classList.add('is-hidden');
        });
    });
</script>
@endsection
