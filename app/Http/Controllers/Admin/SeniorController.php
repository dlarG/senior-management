<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        ]);

        $user = User::create([
            ...$request->all(),
            'password' => Hash::make($request->password),
            'roleType' => 'senior'
        ]);
        $user->sendEmailVerificationNotification();
        return redirect()->route('admin.seniors.index')->with('success', 'Senior citizen added successfully');
    }
    public function edit(User $senior) {
        return view('admin.seniors.edit', compact('senior'));
    }
    public function update(Request $request, User $senior) {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,'.$senior->id,
            'email' => 'required|email|unique:users,email,'.$senior->id,
            'status' => 'required|in:active,inactive,deceased'
        ]);

        $senior->update($request->all());
        return redirect()->route('admin.seniors.index')->with('success', 'Senior citizen updated successfully');
    }

    public function destroy(User $senior)
    {
        $senior->delete();
        return redirect()->route('admin.seniors.index')->with('success', 'Senior citizen removed successfully');
    }
}
