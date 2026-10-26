@extends('layouts.app')

@section('content')
<div class="rounded-2xl border border-neutral-200 bg-white p-5 sm:p-6">
    <h1 class="text-lg font-bold text-neutral-900">Buat postingan</h1>
    <p class="mt-1 text-sm text-neutral-500">Tulis pertanyaan, info, atau ajakan untuk mahasiswa lain.</p>

    <form method="POST" action="{{ route('post.store') }}" class="mt-6 space-y-5">
        @csrf

        <div class="space-y-1.5">
            <label for="kampus" class="block text-sm font-semibold text-neutral-900">Nama kampus</label>
            <input id="kampus" name="kampus" type="text" value="{{ old('kampus') }}" required maxlength="100"
                placeholder="Contoh: Universitas Brawijaya"
                class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-sm focus:border-neutral-900 focus:ring-0">
            @error('kampus')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div class="space-y-1.5">
                <label for="scope" class="block text-sm font-semibold text-neutral-900">Forum</label>
                <select id="scope" name="scope" required
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-sm focus:border-neutral-900 focus:ring-0">
                    <option value="Kota" @selected(old('scope') === 'Kota')>Forum Kota</option>
                    <option value="Kampus" @selected(old('scope') === 'Kampus')>Forum Kampus</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label for="prodi" class="block text-sm font-semibold text-neutral-900">Prodi</label>
                <select id="prodi" name="prodi" required
                    class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-sm focus:border-neutral-900 focus:ring-0">
                    <option value="">Pilih prodi</option>
                    @foreach ($daftarProdi as $prodi)
                        <option value="{{ $prodi }}" @selected(old('prodi') === $prodi)>{{ $prodi }}</option>
                    @endforeach
                </select>
                @error('prodi')
                    <p class="text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="space-y-1.5">
            <label for="konten" class="block text-sm font-semibold text-neutral-900">Isi postingan</label>
            <textarea id="konten" name="konten" rows="5" required maxlength="500"
                placeholder="Apa yang ingin kamu bagikan?"
                class="block w-full rounded-xl border-neutral-300 px-4 py-2.5 text-sm placeholder:text-neutral-400 focus:border-neutral-900 focus:ring-0">{{ old('konten') }}</textarea>
            @error('konten')
                <p class="text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ url('/') }}"
                class="rounded-full px-4 py-2 text-sm font-medium text-neutral-600 hover:bg-neutral-100">Batal</a>
            <button type="submit"
                class="rounded-full bg-neutral-900 px-5 py-2 text-sm font-semibold text-white hover:bg-neutral-700">
                Terbitkan
            </button>
        </div>
    </form>
</div>
@endsection