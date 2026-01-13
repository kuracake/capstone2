<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- PERBAIKAN LOGIKA DEVELOPER ---
        
        // Cek User yang login
        $user = $request->user();

        // Jika user adalah admin (True karena sudah di-cast boolean di Model)
        if ($user->is_admin === true) {
            // Paksa redirect ke dashboard admin, jangan gunakan intended() untuk admin
            // agar mereka tidak tersesat kembali ke halaman home.
            return redirect()->route('admin.dashboard');
        }

        // --- AKHIR PERBAIKAN ---

        // Untuk user biasa, gunakan intended agar user experience lebih baik
        // (misal: user mau checkout -> login -> kembali ke checkout)
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
