<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
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
        $totalPrograms = Program::where('status', 'upcoming')->count();
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
        $monthlySeniorRegistrations = User::where('roleType', 'senior')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Prepare data for all 12 months (fill missing months with 0)
        $months = [];
        $counts = [];
        foreach (range(1, 12) as $m) {
            $months[] = date('M', mktime(0, 0, 0, $m, 1));
            $counts[] = $monthlySeniorRegistrations[$m] ?? 0;
        }
        // Recent Activities (Last 5 from both models)
        $recentActivities = ActivityLog::with(['user', 'subject'])
            ->latest()
            ->take(4)
            ->get()
            ->map(function ($activity) {
                return [
                    'description' => $activity->description,
                    'user' => $activity->user->name ?? 'System',
                    'subject' => $activity->subject ? $activity->subject->name ?? class_basename($activity->subject) : null,
                    'date' => $activity->created_at,
                    'icon' => $this->getActivityIcon($activity)
                ];
            });

        return view('admin.dashboard', compact(
            'totalAdmins',
            'totalSeniors',
            'totalInactiveUser',
            'totalActiveUsers',
            'totalDeceasedUsers',
            'totalPrograms',
            'seniorGrowthPercentage',
            'newProgramsThisWeek',
            'recentActivities',
            'months',
            'counts'
        ));
    }
    private function getActivityIcon(ActivityLog $activity)
    {
        $subjectType = $activity->subject_type ? class_basename($activity->subject_type) : null;

        return match (true) {
            str_contains($activity->description, 'added') => 'bx-user-plus',
            str_contains($activity->description, 'updated') => 'bx-edit',
            str_contains($activity->description, 'deleted') => 'bx-trash',
            $subjectType === 'Program' => 'bx-calendar-event',
            $subjectType === 'User' => 'bx-user',
            default => 'bx-info-circle'
        };
    }
}