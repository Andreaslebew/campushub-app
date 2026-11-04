<x-guest-layout>
    <h1 class="text-lg font-bold text-neutral-900">Daftar</h1>
    <p class="mt-0.5 mb-5 text-xs sm:text-sm text-neutral-500">Isi data kampusmu agar forum yang kamu lihat sesuai dengan kota dan kampus.</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="space-y-1.5">
            <x-input-label for="name" value="Nama lengkap" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="space-y-1.5">
                <x-input-label for="nim" value="NIM" />
                <x-text-input id="nim" type="text" name="nim" :value="old('nim')" required inputmode="numeric" />
                <x-input-error :messages="$errors->get('nim')" />
            </div>

            <div class="space-y-1.5">
                <x-input-label for="prodi" value="Program studi" />
                <select id="prodi" name="prodi" required class="block w-full rounded-xl border-neutral-300 bg-white px-4 py-2.5 text-xs sm:text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
                    <option value="">Pilih prodi</option>
                    @foreach ($daftarProdi as $prodi)
                        <option value="{{ $prodi }}" @selected(old('prodi') === $prodi)>{{ $prodi }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('prodi')" />
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div class="space-y-1.5">
                <x-input-label for="kota" value="Kota" />
                <select id="kota" name="kota" required class="block w-full rounded-xl border-neutral-300 bg-white px-4 py-2.5 text-xs sm:text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
                    <option value="">Pilih kota</option>
                    @foreach ($daftarKota as $kota)
                        <option value="{{ $kota }}" @selected(old('kota') === $kota)>{{ $kota }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('kota')" />
            </div>

            <div class="space-y-1.5">
                <x-input-label for="kampus" value="Kampus" />
                <select id="kampus" name="kampus" required class="block w-full rounded-xl border-neutral-300 bg-white px-4 py-2.5 text-xs sm:text-sm text-neutral-900 focus:border-neutral-900 focus:ring-0">
                    <option value="">Pilih kampus</option>
                    @foreach ($daftarKampus as $kampus)
                        <option value="{{ $kampus }}" @selected(old('kampus') === $kampus)>{{ $kampus }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('kampus')" />
            </div>
        </div>

        <div class="space-y-1.5">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="space-y-1.5">
            <x-input-label for="password" value="Kata sandi" />
            <x-password-input id="password" name="password" autocomplete="new-password" required />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="space-y-1.5">
            <x-input-label for="password_confirmation" value="Konfirmasi kata sandi" />
            <x-password-input id="password_confirmation" name="password_confirmation" autocomplete="new-password" required />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>
        
        <div class="pt-2">
            <x-primary-button class="w-full">Daftar</x-primary-button>
        </div>
    </form>

    <p class="mt-6 text-center text-xs sm:text-sm text-neutral-500">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="font-semibold text-neutral-900 hover:underline">Masuk</a>
    </p>
</x-guest-layout>