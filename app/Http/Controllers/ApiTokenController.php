<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  Illiuminate\Http\Request
     * @return array
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            $token = $request->user()->createToken($request->token_name);

            return ['token' => $token->plainTextToken];
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
