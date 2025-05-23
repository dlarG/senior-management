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

        return redirect('/login')->with('success', 'Account logged out successfully!');
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
            'birthdate' => [
                    'required',
                    'date',
                    function ($attribute, $value, $fail) {
                        $age = now()->diffInYears($value);
                        if ($age < 60) {
                            $fail('You must be at least 60 years old to register as a senior citizen.');
                        }
                    }
                ],
        ]);

        $validate['password'] = Hash::make($validate['password']);

        $user = User::create($validate);
        $user->sendEmailVerificationNotification(); // Send verification email
    
        return redirect('/login')->with('success', 'Account created successfully. Please check your email for verification instructions.');
    }
    public function login(Request $request) {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        if (Auth::attempt([$loginType => $request->input('login'), 'password' => $request->input('password')])) {
            $user = Auth::user();
    
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'You must verify your email before logging in.'
                ])->onlyInput('login');
            }
    
            $request->session()->regenerate();
    
            if ($user->roleType === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully');
            } else {
                return redirect()->route('senior.dashboard')->with('success', 'Logged in successfully');
            }
        }
    
        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }
}
