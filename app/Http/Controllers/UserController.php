<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display user register form.
     */
    public function register(): View
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function handleRegister(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
            'is_adult' => ['accepted'],
        ]);

        $is_adult_formatted = false;
        if ($request->is_adult === 'on') {
            $is_adult_formatted = true;
        }

        // create user
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => $request->password,
            'is_adult' => $is_adult_formatted,
        ]);

        // create user's todo list
        $user->todoList()->create();

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display user login form.
     */
    public function login(): View
    {
        return view('auth.login');
    }

    /**
     * Handle user logging.
     */
    public function handleLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('users.login');
    }
}
