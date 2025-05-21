<!DOCTYPE html>
<html>
<head>
    <title>System Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 2rem; }
        .metric-card { margin-bottom: 1rem; padding: 1rem; border: 1px solid #eee; }
        .activity-log { margin-top: 2rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.5rem; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="header">
        <h1>System Report - {{ now()->format('F j, Y') }}</h1>
    </div>

    <h2>Key Metrics</h2>
    <div class="metrics">
        <div class="metric-card">
            <strong>Total Seniors:</strong> {{ $metrics['totalSeniors'] }}
        </div>
        <!-- Add other metrics similarly -->
    </div>

    <h2 class="activity-log">Recent Activities</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Activity</th>
                <th>Subject</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td>{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $activity->user->name ?? 'System' }}</td>
                <td>{{ $activity->description }}</td>
                <td>
                    @if($activity->subject)
                        {{ class_basename($activity->subject) }}: {{ $activity->subject->name ?? $activity->subject->id }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>