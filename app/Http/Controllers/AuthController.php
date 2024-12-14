<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

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
        $user->password = $request->password_hash;
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

            return redirect()->intended('teams')->with('success', 'Login success!');
        }

        return back()->with([
            'error' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("login")->with('success', 'Logged out!');
    }

    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function loginGoogle() {
        Log::info('Google Callback Hit');
        Log::info('State: ' . request('state'));
        Log::info('Code: ' . request('code'));
        try{
            $user = Socialite::driver('google')->user();
            // dd($user);
            if ($user) {
                $authUser = User::firstOrCreate([
                    'email' => $user->getEmail(),
                ],[
                    'display_name' => $user->getName(),
                    'password_hash' => Hash::make('user'), // idk ini harus diisi gmn
                    'global_role' => 'user',
                ]);

                Auth::login($authUser);
                return redirect()->route('teams')->with('success', 'Login Success!');
            }
        } catch (Exception $e){
            Log::error('Login Google Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Google login failed!');
        }
    }
}
