<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN LOGIN
    |--------------------------------------------------------------------------
    */
    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN REGISTER
    |--------------------------------------------------------------------------
    */
    public function showRegister()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES REGISTER
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with([
            'success' => 'Akun berhasil dibuat'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES LOGIN
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK LOGIN
        |--------------------------------------------------------------------------
        */
        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with([
            'error' => 'Email atau password salah'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}