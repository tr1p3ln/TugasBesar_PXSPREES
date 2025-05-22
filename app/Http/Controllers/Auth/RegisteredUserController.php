<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Tambahkan validasi dan format +62
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'regex:/^[0-9]{9,13}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Format nomor jadi +62
        $fullPhoneNumber = '+62' . ltrim($request->phone, '0');


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $fullPhoneNumber,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // return redirect(route('dashboard', absolute: false));
        // Tidak langsung login, tapi redirect ke halaman login dengan pesan
        return redirect()->route('login')
            ->with('success', 'Link verifikasi telah dikirim ke email Anda. Silakan verifikasi sebelum login.');
    }
}
