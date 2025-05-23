<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SeniorController extends Controller
{
    public function index() {
        $seniors = User::where('roleType', 'senior')->get();
        return view('admin.seniors.index', compact('seniors'));
    }
    public function create() {
        return view('admin.seniors.create');
    }
    public function store(Request $request) {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'birthdate' => [
                            'required',
                            'date',
                            function ($attribute, $value, $fail) {
                                $age = now()->diffInYears($value);
                                if ($age < 60) {
                                    $fail('The user must be at least 60 years old.');
                                }
                            }
            ]
        ]);

        $user = User::create([
            ...$request->all(),
            'password' => Hash::make($request->password),
            'roleType' => 'senior'
        ]);
        $user->sendEmailVerificationNotification();
        ActivityLogger::log("Senior citizen added", $user);
        return redirect()->route('admin.seniors.index')->with('success', 'Senior citizen added successfully. Please check their email for verification');
    }
    public function edit(User $senior) {
        return view('admin.seniors.edit', compact('senior'));
    }
    public function update(Request $request, User $senior) {
        $rules = [
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,'.$senior->id,
            'status' => 'required|in:active,inactive,deceased',
            'birthdate' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $age = now()->diffInYears($value);
                    if ($age < 60) {
                        $fail('The user must be at least 60 years old.');
                    }
                }
            ]
        ];

        // Only validate email if provided
        if ($request->filled('email')) {
            $rules['email'] = 'email|unique:users,email,'.$senior->id;
        }

        $validated = $request->validate($rules);

        // If email is blank, keep the current email
        if (!$request->filled('email')) {
            $validated['email'] = $senior->email;
        }

        $senior->update($validated);
        ActivityLogger::log("Senior citizen updated", $senior);
        return redirect()->route('admin.seniors.index')->with('status', 'Senior citizen updated successfully');
    }

    public function destroy(User $senior)
    {
        $senior->delete();
        ActivityLogger::log("Deleted senior citizen", $senior);
        return redirect()->route('admin.seniors.index')->with('success', 'Senior citizen removed successfully');
    }
}
