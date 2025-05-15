<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginview() {
        return view('auth.login');
    }
    public function registerview() {
        return view('auth.register');
    }
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('auth.login')->with('success', 'Account logged out successfully!');
    }
    public function register(Request $request) {
        $validate = $request->validate([
            'firstname' => 'required|string',
            'middlename' => 'nullable|string',
            'lastname' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => [
                                'required',
                                'min:6',
                                'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&]).+$/',
                                'confirmed'
                            ],
            'roleType' => 'required|string',
        ]);

        $validate['password'] = Hash::make($validate['password']);

        User::create($validate);

        return redirect('/login')->with('success', 'Account created successfully');
    }
    public function login(Request $request) {
        $request->validate([
            'login' => 'required|string', 
            'password' => 'required|string',
        ]);
    
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        if (Auth::attempt([$loginType => $request->input('login'), 'password' => $request->input('password')])) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Logged in successfully');
        }
    
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }
}
