<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }


    /**
     * Proses login admin
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'min:6',
            ],
        ], [

            'email.required' =>
                'Email wajib diisi.',

            'email.email' =>
                'Format email tidak valid.',

            'password.required' =>
                'Password wajib diisi.',

            'password.min' =>
                'Password minimal 6 karakter.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | LOGIN
        |--------------------------------------------------------------------------
        */

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();


            /*
            |--------------------------------------------------------------------------
            | CEK ROLE ADMIN
            |--------------------------------------------------------------------------
            */

            if (
                Auth::user()->role !== 'admin'
            ) {

                Auth::logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' =>
                        'Akun ini bukan akun Administrator.'
                ]);

            }


            return redirect()
                ->intended(
                    route('dashboard')
                )
                ->with(
                    'success',
                    'Selamat datang, Administrator!'
                );
        }


        return back()
            ->withErrors([
                'email' =>
                    'Email atau password salah.'
            ])
            ->onlyInput('email');
    }


    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();


        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()
            ->route('login')
            ->with(
                'success',
                'Anda berhasil logout.'
            );
    }
}