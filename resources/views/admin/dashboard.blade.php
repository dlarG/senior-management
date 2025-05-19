@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Statistics Cards -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Seniors</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalSeniors }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                <i class='bx bx-user-plus text-2xl text-blue-600'></i>
            </div>
        </div>
        <div class="mt-4 text-sm {{ $seniorGrowthPercentage >= 0 ? 'text-green-600' : 'text-red-600' }}">
            <i class='bx {{ $seniorGrowthPercentage >= 0 ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt' }}'></i>
            {{ abs($seniorGrowthPercentage) }}% {{ $seniorGrowthPercentage >= 0 ? 'increase' : 'decrease' }} from last month
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

    <!-- Recent Activities -->
    <div class="col-span-full bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold mb-4 flex items-center">
            <i class='bx bx-time mr-2'></i> Recent Activities
        </h2>
        <div class="space-y-4">
            @forelse($recentActivities as $activity)
            <div class="flex items-start space-x-4">
                <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center">
                    <i class='bx {{ $activity['icon'] }} text-blue-600'></i>
                </div>
                <div>
                    <p class="text-sm font-medium">{{ $activity['title'] }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $activity['name'] }} • 
                        {{ $activity['date']->diffForHumans() }}
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-500 py-4">
                No recent activities found
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection