<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ],
            [
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Email tidak valid!',
                'password.required' => 'Password tidak boleh kosong!',
                'password.min' => 'Password tidak boleh kurang dari 8 karakter!',
            ]
        );

        $credential = $request->only('email','password');
        if (Auth::attempt($credential)) {
            return redirect()->route('home.index');
        } else {
            return redirect()->back()
                ->withErrors('Email-Address And Password tidak sesuai.');
        }
        
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return Redirect('login');
    }
}
