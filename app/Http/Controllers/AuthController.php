<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    // Maximum de tentatives avant blocage
    protected $maxAttempts = 3;
    protected $decayMinutes = 5; // Durée initiale du blocage

    /**
     * Affiche le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traite la tentative de connexion
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'remember' => 'nullable|boolean'
        ]);

        // Vérification du taux de tentatives
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->incrementLockoutDuration($request);
            return $this->sendLockoutResponse($request);
        }
        // Vérification du compte banni AVANT la tentative de connexion
        $user = User::where('email', $request->email)->first();

        if ($user && $user->isBanned()) {
            $banned_days = now()->diffInDays($user->banned_until);
            return back()->withErrors([
                'email' => "Votre compte est suspendu. Temps restant: $banned_days jours."
            ]);
        }
        // Tentative d'authentification
        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request));
            
            return redirect()->intended('dashboard')
                ->with('success', 'Connexion réussie !');
        }

        // Incrémente le compteur de tentatives échouées
        $this->incrementLoginAttempts($request);

        return back()->withErrors([
            'email' => 'Identifiants incorrects. Tentatives restantes: '.$this->remainingAttempts($request),
        ]);
    }

    /**
     * Affiche le formulaire de mot de passe oublié
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Traite la demande de réinitialisation
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Affiche le formulaire de réinitialisation
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Traite la réinitialisation
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Logique de blocage progressive
     */
    protected function incrementLockoutDuration(Request $request)
    {
        $attempts = $this->limiter()->attempts($this->throttleKey($request));
        
        if ($attempts >= 6) { // Après 2 blocages (3+3 tentatives)
            $this->decayMinutes = 60; // 1 heure
            DB::table('users')
                ->where('email', $request->email)
                ->update(['banned_until' => Carbon::now()->addHours(24)]);
        } elseif ($attempts >= 3) { // Après 1er blocage
            $this->decayMinutes = 30; // 30 minutes
        }
    }

    /**
     * Méthodes utilitaires pour le throttling
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')).'|'.$request->ip();
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return RateLimiter::tooManyAttempts(
            $this->throttleKey($request), $this->maxAttempts
        );
    }

    protected function incrementLoginAttempts(Request $request)
    {
        RateLimiter::hit(
            $this->throttleKey($request), $this->decayMinutes * 60
        );
    }

    protected function remainingAttempts(Request $request)
    {
        return RateLimiter::remaining(
            $this->throttleKey($request), $this->maxAttempts
        );
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn(
            $this->throttleKey($request));

        return back()->withErrors([
            'email' => "Trop de tentatives. Veuillez réessayer dans ".gmdate('i:s', $seconds)." minutes."
        ]);
    }

    // ... (Les autres méthodes register, logout, etc. restent les mêmes)

    /**
     * Affiche le formulaire d'inscription
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Traite l'inscription
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Rôle par défaut
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Inscription réussie !');
    }
    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('status', 'Déconnexion réussie.');
    }
}