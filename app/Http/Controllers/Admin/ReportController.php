<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\ActivityLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Get filter parameters
        $reportType = request('report_type', 'seniors');
        $startDate = request('start_date') ? Carbon::parse(request('start_date')) : now()->subDays(30);
        $endDate = request('end_date') ? Carbon::parse(request('end_date')) : now();

        // Base queries
        $userQuery = User::query();
        $programQuery = Program::query();
        $activityQuery = ActivityLog::query();

        // Apply date filters
        $userQuery->whereBetween('created_at', [$startDate, $endDate]);
        $programQuery->whereBetween('created_at', [$startDate, $endDate]);
        $activityQuery->whereBetween('created_at', [$startDate, $endDate]);

        // Apply report type specific filters
        switch ($reportType) {
            case 'seniors':
                $userQuery->where('roleType', 'senior');
                break;
            case 'programs':
                // Add any program-specific filters here
                break;
            case 'users':
                // Add any user-specific filters here
                break;
        }

        // Recent activities with relationships
        $recentActivities = $activityQuery->with(['user', 'subject'])
            ->latest()
            ->take(5)
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

        return view('admin.reports.index', [
            'totalSeniors' => $userQuery->where('roleType', 'senior')->count(),
            'activeSeniors' => $userQuery->clone()->where('status', 'active')->count(),
            'deceasedSeniors' => $userQuery->clone()->where('status', 'deceased')->count(),
            'activePrograms' => $programQuery->where('status', 'upcoming')->count(),
            'totalUsers' => User::count(),
            'programNames' => $programQuery->clone()->pluck('name'),
            'programParticipants' => $programQuery->clone()->withCount('discussions')->pluck('discussions_count'),
            'recentActivities' => $recentActivities,
            'activeSeniorsCount' => $userQuery->clone()->where('status', 'active')->count(),
            'deceasedSeniorsCount' => $userQuery->clone()->where('status', 'deceased')->count(),
        ]);
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

    public function exportPdf()
    {
        $startDate = request('start_date') ? Carbon::parse(request('start_date')) : now()->subDays(30);
        $endDate = request('end_date') ? Carbon::parse(request('end_date')) : now();
        $reportType = request('report_type', 'seniors');

        $userQuery = User::whereBetween('created_at', [$startDate, $endDate]);
        $programQuery = Program::whereBetween('created_at', [$startDate, $endDate]);

        if ($reportType === 'seniors') {
            $userQuery->where('roleType', 'senior');
        }

        $metrics = [
            'totalSeniors' => $userQuery->clone()->count(),
            'activeSeniors' => $userQuery->clone()->where('status', 'active')->count(),
            'inactiveSeniors' => $userQuery->clone()->where('status', 'inactive')->count(),
            'deceasedSeniors' => $userQuery->clone()->where('status', 'deceased')->count(),
            'activePrograms' => $programQuery->clone()->where('status', 'active')->count(),
            'totalUsers' => User::count(),
        ];

        $activities = ActivityLog::with(['user', 'subject'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf', compact('metrics', 'activities'));
        return $pdf->download('report-'.Carbon::now()->format('Y-m-d').'.pdf');
    }

    public function exportCsv()
    {
        $filename = 'report-'.Carbon::now()->format('Y-m-d').'.csv';
        
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            
            // Header
            fputcsv($handle, ['Date', 'User', 'Activity', 'Subject', 'Details']);
            
            ActivityLog::with(['user', 'subject'])
                ->chunk(200, function ($logs) use ($handle) {
                    foreach ($logs as $log) {
                        fputcsv($handle, [
                            $log->created_at->format('Y-m-d H:i:s'),
                            $log->user->name ?? 'System',
                            $log->description,
                            $log->subject ? class_basename($log->subject) : 'N/A',
                            $log->subject ? $log->subject->name ?? $log->subject->id : 'N/A'
                        ]);
                    }
                });
            
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}