@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <!-- Statistics Cards -->
    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Seniors</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalSeniors }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class='bx bx-user-plus text-2xl text-blue-600'></i>
            </div>
        </div>
        <div class="mt-4 text-sm {{ $seniorGrowthPercentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
            <i class='bx {{ $seniorGrowthPercentage >= 0 ? 'bx-trending-up' : 'bx-trending-down' }} mr-1'></i>
            {{ abs($seniorGrowthPercentage) }}% {{ $seniorGrowthPercentage >= 0 ? 'growth' : 'decline' }}
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Active Programs</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalPrograms }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                <i class='bx bx-calendar-check text-2xl text-green-600'></i>
            </div>
        </div>
        <div class="mt-4 text-sm text-blue-600">
            {{ $newProgramsThisWeek }} new {{ Str::plural('program', $newProgramsThisWeek) }} this week
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Unverified Accounts</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalInactiveUser }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-lg flex items-center justify-center">
                <i class='bx bx-time-five text-2xl text-purple-600'></i>
            </div>
        </div>
        <div class="mt-4 text-sm text-red-600">
            {{ $totalInactiveUser }} pending {{ Str::plural('verification', $totalInactiveUser) }}
        </div>
    </div>
</div>

    <!-- Recent Activities -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <i class='bx bx-time mr-2'></i> Recent Activities
        </h3>
        <div class="space-y-4">
            @foreach($recentActivities as $activity)
            <div class="flex items-start space-x-4 group hover:bg-gray-50 p-3 rounded-lg transition-colors">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class='bx {{ $activity['icon'] }} text-blue-600'></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $activity['user'] }}</p>
                            <p class="text-sm text-gray-600">{{ $activity['description'] }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($activity['date'])->diffForHumans() }}</span>
                    </div>
                    @if($activity['subject'])
                    <div class="mt-2 text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                        {{ $activity['subject'] }}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <i class='bx bx-line-chart mr-2'></i> Senior Growth
        </h3>
        <div class="h-64">
            <canvas id="seniorGrowthChart"></canvas>
        </div>
    </div>
</div>
<script>
    // Senior Growth Chart
    const ctx = document.getElementById('seniorGrowthChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Senior Registrations',
                data: @json($counts),
                borderColor: '#3B82F6',
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection