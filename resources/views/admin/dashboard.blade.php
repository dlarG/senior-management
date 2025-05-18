@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Statistics Cards -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Total Seniors</h3>
        <p class="text-3xl font-bold mt-2">1,234</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Active Programs</h3>
        <p class="text-3xl font-bold mt-2">15</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Pending Requests</h3>
        <p class="text-3xl font-bold mt-2">23</p>
    </div>

    <!-- Recent Activities -->
    <div class="col-span-full bg-white p-6 rounded-lg shadow mt-6">
        <h2 class="text-xl font-semibold mb-4">Recent Activities</h2>
        <div class="space-y-4">
            <!-- Activity Items -->
            <div class="border-b pb-2">
                <p class="text-sm text-gray-600">New senior registration - John Doe</p>
                <p class="text-xs text-gray-400">2 hours ago</p>
            </div>
            <!-- Add more activities -->
        </div>
    </div>
</div>
@endsection