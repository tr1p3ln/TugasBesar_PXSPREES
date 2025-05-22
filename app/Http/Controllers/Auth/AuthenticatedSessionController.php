<?php
/* 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
   
    public function create(): View
    {
        return view('auth.login');
    }

  
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

   
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
    */




namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    $request->session()->regenerate();

    $user = Auth::user();

    // Redirect berdasarkan role
    if ($user->role === 'admin') {
        return redirect()->intended(route('admin.home'));
    }

    // Jika bukan admin, redirect ke homepage user
    return redirect()->intended(route('user.home'));
}




    /**
     * Handle post-authentication redirect.
     */
    protected function authenticatedRedirect(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (!$user) {
            Auth::logout();
            return redirect('/login')->withErrors([
                'email' => 'Sesi login tidak valid.',
            ]);
        }

        // Pengecekan role dengan fallback
        switch ($user->role) {
            case 'admin':
                return redirect()->intended(route('admin.dashboard'));
            case 'user':
                return redirect()->intended(route('dashboard'));
            default:
                Auth::logout();
                return redirect('/login')->withErrors([
                    'email' => 'Role pengguna tidak valid.',
                ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        try {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            // Redirect ke halaman login yang sesuai
            return $this->postLogoutRedirect($request);
        } catch (\Exception $e) {
            // Log error jika diperlukan
            return redirect('/')->withErrors([
                'message' => 'Terjadi kesalahan saat logout.',
            ]);
        }
    }

    /**
     * Handle post-logout redirect.
     */
    protected function postLogoutRedirect(Request $request): RedirectResponse
    {
        // Cek apakah sebelumnya dari admin area
        $isFromAdmin = str_contains($request->headers->get('referer'), '/admin');

        return $isFromAdmin
            ? redirect('/admin/login')
            : redirect('/login');
    }
}
