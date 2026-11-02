@extends('layouts.app')

@section('content')
<div class="rounded-2xl border border-neutral-200 bg-white p-5 sm:p-6">
    <div class="mb-5 flex items-center justify-between">
        <div>
            <h1 class="text-lg font-bold text-neutral-900" id="form-title">Buat postingan</h1>
            <p class="mt-0.5 text-xs sm:text-sm text-neutral-500" id="form-desc">Bagikan pertanyaan, info kampus, atau publikasikan event.</p>
        </div>
    </div>

    {{-- Switcher Jenis Postingan --}}
    <div class="type-switcher">
        <button type="button" id="tab-tipe-post" class="type-switcher-btn active">
            💬 Diskusi / Forum
        </button>
        <button type="button" id="tab-tipe-event" class="type-switcher-btn inactive">
            🎟️ Event Kampus
        </button>
    </div>

    <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" id="input-tipe" name="tipe" value="{{ old('tipe', 'post') }}">

        {{-- ================= FORM POSTINGAN BIASA ================= --}}
        <div id="section-post" class="space-y-4">
            <div class="rounded-xl border border-neutral-200 bg-neutral-50 px-4 py-3 text-xs sm:text-sm text-neutral-600">
                Diposting sebagai <span class="font-semibold text-neutral-900">{{ auth()->user()->prodi ?? '-' }}</span>
                · {{ auth()->user()->kampus ?? '-' }} · {{ auth()->user()->kota ?? '-' }}
            </div>

            <div class="space-y-1.5">
                <label for="scope-post" class="block text-xs sm:text-sm font-semibold text-neutral-900">Forum</label>
                <select id="scope-post" name="scope"
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    <option value="Kota" @selected(old('scope') === 'Kota')>Forum Kota</option>
                    <option value="Kampus" @selected(old('scope') === 'Kampus')>Forum Kampus</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label for="konten" class="block text-xs sm:text-sm font-semibold text-neutral-900">Isi postingan</label>
                <textarea id="konten" name="konten" rows="4" maxlength="500"
                    placeholder="Apa yang ingin kamu diskusikan atau tanyakan?"
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">{{ old('konten') }}</textarea>
                @error('konten')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ================= FORM EVENT KAMPUS ================= --}}
        <div id="section-event" class="is-hidden space-y-4">
            <div class="space-y-1.5">
                <label for="judul" class="block text-xs sm:text-sm font-semibold text-neutral-900">Judul event</label>
                <input id="judul" name="judul" type="text" value="{{ old('judul') }}" maxlength="150"
                    placeholder="Contoh: Seminar Nasional Kecerdasan Buatan"
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                @error('judul')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="space-y-1.5">
                    <label for="penyelenggara" class="block text-xs sm:text-sm font-semibold text-neutral-900">Penyelenggara</label>
                    <input id="penyelenggara" name="penyelenggara" type="text" value="{{ old('penyelenggara') }}" maxlength="100"
                        placeholder="Contoh: HMIF Universitas Brawijaya"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    @error('penyelenggara')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="kategori" class="block text-xs sm:text-sm font-semibold text-neutral-900">Kategori event</label>
                    <select id="kategori" name="kategori"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                        @foreach ($daftarKategori as $kat)
                            <option value="{{ $kat }}" @selected(old('kategori') === $kat)>{{ $kat }}</option>
                        @endforeach
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="space-y-1.5">
                    <label for="tanggal" class="block text-xs sm:text-sm font-semibold text-neutral-900">Tanggal pelaksanaan</label>
                    <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', date('Y-m-d')) }}"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    @error('tanggal')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="waktu" class="block text-xs sm:text-sm font-semibold text-neutral-900">Waktu / Jam</label>
                    <input id="waktu" name="waktu" type="text" value="{{ old('waktu') }}" maxlength="100"
                        placeholder="Contoh: 08.00 - 12.00 WIB"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    @error('waktu')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="biaya" class="block text-xs sm:text-sm font-semibold text-neutral-900">Biaya pendaftaran</label>
                    <input id="biaya" name="biaya" type="text" value="{{ old('biaya', 'Gratis') }}" maxlength="50"
                        placeholder="Contoh: Gratis atau Rp 50.000"
                        class="block w-full rounded-xl border-neutral-300 px-4 py-2 text-xs sm:text-sm focus:border-neutral-900 focus:ring-0">
                    @error('biaya')
                        <p class="text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-1.5">
                <label for="deskripsi" class="block text-xs sm:text-sm font-semibold text-neutral-900">Deskripsi event</label>
                <textarea id="deskripsi" name="deskripsi" rows="3" maxlength="1000"
                    placeholder="Jelaskan tema, rincian acara, dan manfaat bagi peserta..."
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-xs sm:text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- ================= LAMPIRAN (FOTO, VIDEO, LOKASI) ================= --}}
        <div class="space-y-2 pt-2">
            {{-- Preview Foto --}}
            <div id="preview-foto-wrap" class="is-hidden">
                <div class="preview-media-box">
                    <img id="preview-foto-img" src="" alt="" class="h-28 w-28 object-cover">
                    <button type="button" id="btn-hapus-foto" class="preview-media-delete-btn" title="Hapus foto">
                        &times;
                    </button>
                </div>
            </div>

            {{-- Preview Video --}}
            <div id="preview-video-wrap" class="is-hidden">
                <div class="preview-media-box bg-black">
                    <video id="preview-video-tag" controls class="h-32 max-w-xs"></video>
                    <button type="button" id="btn-hapus-video" class="preview-media-delete-btn" title="Hapus video">
                        &times;
                    </button>
                </div>
            </div>

            {{-- Preview Lokasi Terpilih --}}
            <div id="preview-lokasi-wrap" class="is-hidden">
                <span class="chip-lokasi">
                    <svg class="h-3.5 w-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-5.5-7-11a7 7 0 1114 0c0 5.5-7 11-7 11z" />
                        <circle cx="12" cy="10" r="2.5" />
                    </svg>
                    <span id="preview-lokasi-text" class="truncate max-w-[220px]"></span>
                    <button type="button" id="btn-hapus-lokasi" class="ml-1 text-emerald-700 hover:text-rose-600 font-bold" title="Hapus lokasi">&times;</button>
                </span>
            </div>

            {{-- Panel Pilihan Lokasi Google Maps --}}
            <div id="panel-lokasi" class="is-hidden attachment-panel space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-neutral-800 flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-rose-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                        </svg>
                        Lokasi / Tempat Acara
                    </span>
                    <button type="button" id="btn-tutup-lokasi" class="text-xs text-neutral-400 hover:text-neutral-700">&times; Tutup</button>
                </div>

                {{-- Opsi 1: Gunakan Lokasi Saat Ini (GPS) --}}
                <button type="button" id="btn-gps" class="w-full flex items-center justify-center gap-2 rounded-xl bg-white border border-neutral-300 py-2.5 px-3 text-xs font-semibold text-neutral-800 hover:border-neutral-900 hover:bg-neutral-100 transition shadow-sm">
                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3" />
                        <path stroke-linecap="round" d="M12 2v3m0 14v3M2 12h3m14 0h3" />
                    </svg>
                    <span id="gps-status">Gunakan Lokasi Saat Ini (GPS)</span>
                </button>

                <div class="relative flex items-center justify-center">
                    <span class="h-px w-full bg-neutral-200"></span>
                    <span class="absolute bg-neutral-50 px-2 text-[10px] text-neutral-400 uppercase tracking-wider">atau</span>
                </div>

                {{-- Opsi 2: Cari / Ketik Nama Tempat --}}
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-semibold text-neutral-600">Pilih tempat atau gedung</label>
                        <a href="https://www.google.com/maps" target="_blank" rel="noopener noreferrer" class="text-[11px] text-blue-600 hover:underline inline-flex items-center gap-0.5">
                            Buka Google Maps
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                    </div>
                    <div class="flex gap-2">
                        <input type="text" id="input-lokasi-nama" name="lokasi_nama"
                            placeholder="Contoh: Gedung Teknik Informatika, Malang"
                            class="min-w-0 flex-1 rounded-xl border-neutral-300 bg-white text-xs placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">
                        <button type="button" id="btn-simpan-lokasi"
                            class="shrink-0 rounded-xl bg-neutral-900 px-3.5 py-2 text-xs font-semibold text-white hover:bg-neutral-700">
                            Pilih
                        </button>
                    </div>
                </div>

                <input type="hidden" id="input-lokasi-url" name="lokasi" value="">
            </div>

            {{-- Toolbar Tombol Lampiran (Hanya Icon Saja) --}}
            <div class="flex items-center gap-1 pt-2 border-t border-neutral-100">
                <button type="button" id="btn-pilih-foto" class="toolbar-icon-btn btn-foto" title="Tambah Poster / Foto">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </button>
                <input type="file" id="input-foto" name="foto" accept="image/*" class="hidden">

                <button type="button" id="btn-pilih-video" class="toolbar-icon-btn btn-video" title="Tambah Teaser / Video">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </button>
                <input type="file" id="input-video" name="video" accept="video/*" class="hidden">

                <button type="button" id="btn-buka-lokasi" class="toolbar-icon-btn btn-lokasi" title="Lokasi Google Maps">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3">
            <a href="{{ url('/') }}"
                class="rounded-full px-4 py-2 text-xs sm:text-sm font-medium text-neutral-600 hover:bg-neutral-100">Batal</a>
            <button type="submit" id="btn-submit"
                class="rounded-full bg-neutral-900 px-6 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-neutral-700">
                Terbitkan
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tipe switcher
        const tabPost = document.getElementById('tab-tipe-post');
        const tabEvent = document.getElementById('tab-tipe-event');
        const sectionPost = document.getElementById('section-post');
        const sectionEvent = document.getElementById('section-event');
        const inputTipe = document.getElementById('input-tipe');
        const formTitle = document.getElementById('form-title');
        const formDesc = document.getElementById('form-desc');
        const btnSubmit = document.getElementById('btn-submit');

        function setMode(mode) {
            inputTipe.value = mode;
            if (mode === 'event') {
                tabEvent.classList.add('active');
                tabEvent.classList.remove('inactive');
                tabPost.classList.add('inactive');
                tabPost.classList.remove('active');

                sectionPost.classList.add('is-hidden');
                sectionEvent.classList.remove('is-hidden');

                formTitle.textContent = 'Publikasikan Event';
                formDesc.textContent = 'Isi rincian kegiatan atau lomba agar mahasiswa dapat mengetahui dan mendaftar.';
                btnSubmit.textContent = 'Publikasikan Event';
            } else {
                tabPost.classList.add('active');
                tabPost.classList.remove('inactive');
                tabEvent.classList.add('inactive');
                tabEvent.classList.remove('active');

                sectionEvent.classList.add('is-hidden');
                sectionPost.classList.remove('is-hidden');

                formTitle.textContent = 'Buat postingan';
                formDesc.textContent = 'Tulis pertanyaan, info, atau ajakan untuk mahasiswa lain.';
                btnSubmit.textContent = 'Terbitkan';
            }
        }

        tabPost.addEventListener('click', () => setMode('post'));
        tabEvent.addEventListener('click', () => setMode('event'));

        if (inputTipe.value === 'event') {
            setMode('event');
        }

        // Foto
        const btnFoto = document.getElementById('btn-pilih-foto');
        const inputFoto = document.getElementById('input-foto');
        const wrapFoto = document.getElementById('preview-foto-wrap');
        const imgFoto = document.getElementById('preview-foto-img');
        const btnHapusFoto = document.getElementById('btn-hapus-foto');

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
        const btnVideo = document.getElementById('btn-pilih-video');
        const inputVideo = document.getElementById('input-video');
        const wrapVideo = document.getElementById('preview-video-wrap');
        const tagVideo = document.getElementById('preview-video-tag');
        const btnHapusVideo = document.getElementById('btn-hapus-video');

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
        const btnBukaLokasi = document.getElementById('btn-buka-lokasi');
        const btnTutupLokasi = document.getElementById('btn-tutup-lokasi');
        const panelLokasi = document.getElementById('panel-lokasi');
        const inputNama = document.getElementById('input-lokasi-nama');
        const inputUrl = document.getElementById('input-lokasi-url');
        const btnSimpanLokasi = document.getElementById('btn-simpan-lokasi');
        const wrapLokasi = document.getElementById('preview-lokasi-wrap');
        const textLokasi = document.getElementById('preview-lokasi-text');
        const btnHapusLokasi = document.getElementById('btn-hapus-lokasi');
        const btnGps = document.getElementById('btn-gps');
        const gpsStatus = document.getElementById('gps-status');

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
