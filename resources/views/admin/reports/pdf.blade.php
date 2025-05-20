<!DOCTYPE html>
<html>
<head>
    <title>System Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>System Report</h2>
    <table>
        <tr><th>Total Seniors</th><td>{{ $totalSeniors }}</td></tr>
        <tr><th>Active Seniors</th><td>{{ $activeSeniors }}</td></tr>
        <tr><th>Inactive Seniors</th><td>{{ $inactiveSeniors }}</td></tr>
        <tr><th>Deceased Seniors</th><td>{{ $deceasedSeniors }}</td></tr>
        <tr><th>Active Programs</th><td>{{ $activePrograms }}</td></tr>
        <tr><th>Total Users</th><td>{{ $totalUsers }}</td></tr>
    </table>
</body>
</html>
