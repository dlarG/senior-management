<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {

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
        return view('admin.reports.index', [
            'totalSeniors' => User::where('roleType', 'senior')->count(),
            'activeSeniors' => User::where('status', 'active')->count(),
            'inactiveSeniors' => User::where('status', 'inactive')->count(),
            'deceasedSeniors' => User::where('status', 'deceased')->count(),
            'activePrograms' => Program::where('status', 'active')->count(),
            'totalUsers' => User::count(),
            'programNames' => Program::pluck('name'),
            'programParticipants' => Program::withCount('discussions')->pluck('discussions_count')
        ], compact('recentActivities'));
    }
    public function exportPdf()
    {
        $totalSeniors = User::where('roleType', 'senior')->count();
        $activeSeniors = User::where('status', 'active')->count();
        $inactiveSeniors = User::where('status', 'inactive')->count();
        $deceasedSeniors = User::where('status', 'deceased')->count();
        $activePrograms = Program::where('status', 'active')->count();
        $totalUsers = User::count();

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'totalSeniors',
            'activeSeniors',
            'inactiveSeniors',
            'deceasedSeniors',
            'activePrograms',
            'totalUsers'
        ));

        return $pdf->download('report.pdf');
    }
    public function exportCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="report.csv"',
        ];

        $data = [
            ['Metric', 'Value'],
            ['Total Seniors', User::where('roleType', 'senior')->count()],
            ['Active Seniors', User::where('status', 'active')->count()],
            ['Inactive Seniors', User::where('status', 'inactive')->count()],
            ['Deceased Seniors', User::where('status', 'deceased')->count()],
            ['Active Programs', Program::where('status', 'active')->count()],
            ['Total Users', User::count()],
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

}