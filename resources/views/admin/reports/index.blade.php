@extends('layouts.admin')

@section('title', 'System Reports')

@section('content')
<div class="space-y-8">
    <!-- Report Filters -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Report Filters</h2>
        <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date Range</label>
                <input name="start_date" style="height: 40px;" type="date" 
                    value="{{ request('start_date') }}" 
                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Report Type</label>
                <select name="report_type" style="height: 40px;" 
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="seniors" {{ request('report_type') == 'seniors' ? 'selected' : '' }}>Senior Citizens</option>
                    <option value="programs" {{ request('report_type') == 'programs' ? 'selected' : '' }}>Programs</option>
                    <option value="users" {{ request('report_type') == 'users' ? 'selected' : '' }}>Users</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-4 py-2 rounded-lg font-semibold shadow hover:from-blue-600 hover:to-indigo-600 w-full transition">
                    <i class='bx bx-bar-chart mr-2'></i>Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between hover:shadow-xl transition">
            <div>
                <p class="text-sm text-gray-500">Total Seniors</p>
                <p class="text-3xl font-extrabold text-blue-600">{{ $totalSeniors }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class='bx bx-group text-3xl text-blue-500'></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between hover:shadow-xl transition">
            <div>
                <p class="text-sm text-gray-500">Active Programs</p>
                <p class="text-3xl font-extrabold text-green-600">{{ $activePrograms }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class='bx bx-calendar-event text-3xl text-green-500'></i>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center justify-between hover:shadow-xl transition">
            <div>
                <p class="text-sm text-gray-500">Registered Users</p>
                <p class="text-3xl font-extrabold text-purple-600">{{ $totalUsers }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <i class='bx bx-user text-3xl text-purple-500'></i>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Senior Citizen Status Distribution</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="statusChart" class="w-full h-full"></canvas>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Program Participation</h3>
            <div class="h-64 flex items-center justify-center">
                <canvas id="programChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Data Export -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h3 class="text-lg font-semibold mb-4 md:mb-0 text-gray-800">Export Data</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.reports.export.csv', request()->query()) }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 flex items-center transition">
                <i class='bx bx-download mr-2'></i>Export as CSV
            </a>
            <a href="{{ route('admin.reports.export.pdf', request()->query()) }}" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 flex items-center transition">
                <i class='bx bx-file-pdf mr-2'></i>Export as PDF
            </a>
            <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center transition">
                <i class='bx bx-printer mr-2'></i>Print Report
            </button>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Recent System Activity</h3>
        <div class="space-y-4">
            @forelse($recentActivities as $activity)
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b pb-2 gap-2">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 rounded-full p-2">
                        <i class='bx {{ $activity['icon'] }} text-blue-500'></i>
                    </div>
                    <div>
                        <span class="text-sm font-semibold text-gray-800">{{ $activity['user'] }}</span>
                        <span class="text-sm text-gray-600">{{ $activity['description'] }}</span>
                        @if($activity['subject'])
                            <span class="text-xs text-gray-400">({{ $activity['subject'] }})</span>
                        @endif
                    </div>
                </div>
                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($activity['date'])->diffForHumans() }}</span>
            </div>
            @empty
            <p class="text-gray-500 text-sm">No recent activity.</p>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Status Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Deceased'],
            datasets: [{
                data: [{{ $activeSeniorsCount }}, {{ $deceasedSeniorsCount }}],
                backgroundColor: ['#3B82F6', '#EF4444']
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 14 } }
                }
            }
        }
    });

    // Program Chart
    new Chart(document.getElementById('programChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($programNames) !!},
            datasets: [{
                label: 'Participants',
                data: {!! json_encode($programParticipants) !!},
                backgroundColor: '#10B981'
            }]
        },
        options: {
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { ticks: { font: { size: 13 } } },
                y: { beginAtZero: true, ticks: { font: { size: 13 } } }
            }
        }
    });
</script>
@endpush
@endsection