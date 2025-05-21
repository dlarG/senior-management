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
        $recentActivities = ActivityLog::with(['user', 'subject'])
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
            'totalSeniors' => User::where('roleType', 'senior')->count(),
            'activeSeniors' => User::where('status', 'active')->count(),
            'inactiveSeniors' => User::where('status', 'inactive')->count(),
            'deceasedSeniors' => User::where('status', 'deceased')->count(),
            'activePrograms' => Program::where('status', 'upcoming')->count(),
            'totalUsers' => User::count(),
            'programNames' => Program::pluck('name'),
            'programParticipants' => Program::withCount('discussions')->pluck('discussions_count'),
            'recentActivities' => $recentActivities
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
        $metrics = [
            'totalSeniors' => User::where('roleType', 'senior')->count(),
            'activeSeniors' => User::where('status', 'active')->count(),
            'inactiveSeniors' => User::where('status', 'inactive')->count(),
            'deceasedSeniors' => User::where('status', 'deceased')->count(),
            'activePrograms' => Program::where('status', 'active')->count(),
            'totalUsers' => User::count(),
        ];

        $activities = ActivityLog::with(['user', 'subject'])
            ->where('created_at', '>=', now()->subDays(30))
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