<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // User Statistics
        $totalAdmins = User::where('roleType', 'admin')->count();
        $totalSeniors = User::where('roleType', 'senior')->count();
        $totalInactiveUser = User::whereNull('email_verified_at')->count();
        $totalActiveUsers = User::where('status', 'active')->count();
        $totalDeceasedUsers = User::where('status', 'deceased')->count();
        
        // Program Statistics
        $totalPrograms = Program::where('status', 'active')->count();
        $newProgramsThisWeek = Program::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        // Senior Growth Calculation
        $currentMonthSeniors = User::where('roleType', 'senior')
            ->whereMonth('created_at', now()->month)
            ->count();
            
        $lastMonthSeniors = User::where('roleType', 'senior')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();
            
        $seniorGrowthPercentage = $lastMonthSeniors > 0 
            ? round(($currentMonthSeniors - $lastMonthSeniors) / $lastMonthSeniors * 100, 2)
            : 100;

        // Recent Activities (Last 5 from both models)
        $userActivities = User::latest()
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user',
                    'title' => $user->roleType === 'senior' ? 'New Senior Registered' : 'New Admin Added',
                    'name' => $user->fullname,
                    'date' => $user->created_at,
                    'icon' => $user->roleType === 'senior' ? 'bx-user-plus' : 'bx-shield-plus'
                ];
            });

        $programActivities = Program::latest()
            ->take(5)
            ->get()
            ->map(function ($program) {
                return [
                    'type' => 'program',
                    'title' => 'New Program Created',
                    'name' => $program->name,
                    'date' => $program->created_at,
                    'icon' => 'bx-calendar-plus'
                ];
            });

        $recentActivities = $userActivities->merge($programActivities)
            ->sortByDesc('date')
            ->take(5);

        return view('admin.dashboard', compact(
            'totalAdmins',
            'totalSeniors',
            'totalInactiveUser',
            'totalActiveUsers',
            'totalDeceasedUsers',
            'totalPrograms',
            'seniorGrowthPercentage',
            'newProgramsThisWeek',
            'recentActivities'
        ));
    }
}