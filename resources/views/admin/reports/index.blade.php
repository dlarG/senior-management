@extends('layouts.admin')

@section('title', 'System Reports')

@section('content')
<div class="space-y-6">
    <!-- Report Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold mb-4">Report Filters</h2>
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Date Range</label>
                <input type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Report Type</label>
                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="seniors">Senior Citizens</option>
                    <option value="programs">Programs</option>
                    <option value="users">Users</option>
                </select>
            </div>
            <div class="flex items-end">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 w-full">
                    Generate Report
                </button>
            </div>
        </form>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Seniors</p>
                    <p class="text-2xl font-semibold">{{ $totalSeniors }}</p>
                </div>
                <i class='bx bx-group text-3xl text-blue-500'></i>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Active Programs</p>
                    <p class="text-2xl font-semibold">{{ $activePrograms }}</p>
                </div>
                <i class='bx bx-calendar-event text-3xl text-green-500'></i>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Registered Users</p>
                    <p class="text-2xl font-semibold">{{ $totalUsers }}</p>
                </div>
                <i class='bx bx-user text-3xl text-purple-500'></i>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Senior Citizen Status Distribution</h3>
            <canvas id="statusChart" class="w-full h-64"></canvas>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Program Participation</h3>
            <canvas id="programChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- Data Export -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Export Data</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.reports.export.csv') }}" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">
                <i class='bx bx-download mr-2'></i>Export as CSV
            </a>
        
            <a href="{{ route('admin.reports.export.pdf') }}" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">
                <i class='bx bx-file-pdf mr-2'></i>Export as PDF
            </a>
        
            <button onclick="window.print()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class='bx bx-printer mr-2'></i>Print Report
            </button>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Recent System Activity</h3>
        <div class="space-y-4">
            @foreach($recentActivities as $activity)
            <div class="flex items-center justify-between border-b pb-2">
                <div class="flex items-center space-x-3">
                    <i class='bx {{ $activity['icon'] }} text-blue-500'></i>
                    <div>
                        <span class="text-sm font-medium">{{ $activity['user'] }}</span>
                        <span class="text-sm">{{ $activity['description'] }}</span>
                        @if($activity['subject'])
                            <span class="text-xs text-gray-500">({{ $activity['subject'] }})</span>
                        @endif
                    </div>
                </div>
                <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($activity['date'])->diffForHumans() }}</span>
            </div>
            @endforeach
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
            labels: ['Active', 'Inactive', 'Deceased'],
            datasets: [{
                data: [{{ $activeSeniors }}, {{ $inactiveSeniors }}, {{ $deceasedSeniors }}],
                backgroundColor: ['#3B82F6', '#F59E0B', '#EF4444']
            }]
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
        }
    });
</script>
@endpush
@endsection