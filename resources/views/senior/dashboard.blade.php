@extends('layouts.senior')

@section('title', 'Senior Dashboard')

@section('content')
<div class="grid grid-cols-1 gap-6 mb-3">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold mb-3">Hello, {{Auth::user()->firstname}} {{Auth::user()->lastname}} </h2>
                @if (App\Models\Program::where('status', ['upcoming', 'active'])->count() !== 0)
                <p class="text-m text-red-500">There's an upcoming program, check it out.</p>
                @else
                <p class="text-m text-gray-800">Your'e catching up.</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Statistics Cards -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Total Programs</p>
                <p class="text-3xl font-bold text-gray-800">{{ App\Models\Program::count() }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                <i class='bx bx-user-plus text-2xl text-blue-600'></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mb-1">Active Programs</p>
                <p class="text-3xl font-bold text-gray-800">{{ App\Models\Program::where('status', 'active')->count() }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                <i class='bx bx-calendar-check text-2xl text-green-600'></i>
            </div>
        </div>
    </div>
</div>
@endsection