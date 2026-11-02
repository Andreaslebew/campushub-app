<x-guest-layout>
    <h1 class="text-lg font-bold text-neutral-900">Masuk</h1>
    <p class="mt-0.5 mb-5 text-xs sm:text-sm text-neutral-500">Lanjutkan ke forum kota dan kampusmu.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div class="space-y-1.5">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="space-y-1.5">
            <x-input-label for="password" value="Kata sandi" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900">
                <span class="text-xs sm:text-sm text-neutral-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs sm:text-sm font-medium text-neutral-500 hover:text-neutral-900">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">Masuk</x-primary-button>
        </div>
    </form>

    <p class="mt-6 text-center text-xs sm:text-sm text-neutral-500">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold text-neutral-900 hover:underline">Daftar</a>
    </p>
</x-guest-layout>