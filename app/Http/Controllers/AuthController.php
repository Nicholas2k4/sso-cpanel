<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup_authenticate(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password_hash' => 'required'
        ],[
            'email.required' => 'Email cannot be empty',
            'email.unique' => 'This email account is already registered',
            'password_hash.required' => 'password cannot be empty'
        ]);

        $user = new User;

        $user->display_name = explode('@', $request->email)[0];
        $user->email = $request->email;
        $user->password = $request->password_hash; // Properti `password` otomatis mengarah ke `password_hash`.
        $user->global_role = 'user';

        $user->save();

        return redirect('/login')->with('success','Successfully created account!');

    }

    public function login_authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('teams'); 
        }

        return back()->with([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("login");
    }

}
