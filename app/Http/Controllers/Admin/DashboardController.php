<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() {
        $totalAdmins = User::where('roleType', 'admin')->count();
        $totalSeniors = User::where('roleType', 'senior')->count();
        $totalActiveUsers = User::where('status', 'active')->count();
        $totalDeceasedUsers = User::where('status', 'deceased')->count();
        $totalPrograms = Program::count(); // Assuming you'll create the Program model later

        return view('admin.dashboard', [
            'totalAdmins' => $totalAdmins,
            'totalSeniors' => $totalSeniors,
            'totalActiveUsers' => $totalActiveUsers,
            'totalDeceasedUsers' => $totalDeceasedUsers,
            'totalPrograms' => $totalPrograms,
        ]);
    }
}
