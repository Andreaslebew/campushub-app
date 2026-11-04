<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'daftarKota' => array_keys(config('akademik.kota')),
            'kampusPerKota' => config('akademik.kota'),
            'daftarProdi' => config('akademik.prodi'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $kotaTerpilih = (string) $request->input('kota', '');
        $kampusDiKotaTerpilih = config('akademik.kota')[$kotaTerpilih] ?? [];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20', 'unique:'.User::class.',nim'],
            'prodi' => ['required', 'string', Rule::in(config('akademik.prodi'))],
            'kota' => ['required', 'string', Rule::in(array_keys(config('akademik.kota')))],
            'kampus' => ['required', 'string', Rule::in($kampusDiKotaTerpilih)],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'kota' => $request->kota,
            'kampus' => $request->kampus,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}