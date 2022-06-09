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
                    'password' => 'The provided password do not match our records.',
                ])->onlyInput('password');
            }
            Auth::login($user, true);
            return back();
        }


        if (
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ])
        ) {
            Auth::login($user, true);
            return back(201);
        }
        
        /*
        Auth::login($user, true);

        dd($user, Auth::user());

        if (
            Auth::login(User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]), true)
        ) {
            dd('hi');
            return back(201);
        } else {
            dd('hi else');
        }
*/
        return back()->withErrors([
            'email' => 'test The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
