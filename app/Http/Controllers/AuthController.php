<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signIn(Request $request)
    {
        $request->validate([
            'username' => [
                'required',
                'max:255',
                'min:4',
                'string'
            ],
            'password' => 'required|min:8|max:255|string'
        ]);

        if ($user = User::query()->where('username', $request->username)->first()) {
            if (! Hash::check($request->password, $user->password)) {
                return back()->withErrors([
                    'password' => 'The provided credentials do not match our records.',
                ])->onlyInput('password');
            }
            Auth::login($user, true);
            return back();
        }

        if (
            Auth::login(User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]), true)
        ) {
            return back(201);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
