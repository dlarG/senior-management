@extends('layouts.admin')

@section('title', $program->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Program Header -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6">
            <div class="flex items-center mb-4 md:mb-0">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class='bx bx-calendar-event text-blue-600 text-xl'></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $program->name }}</h1>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium
                  {{ $program->status === 'active' ? 'bg-green-100 text-green-800' : 
                     ($program->status === 'successful' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800') }}">
                {{ ucfirst($program->status) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mb-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Start Date</p>
                <p class="font-medium text-gray-900">{{ $program->start_date->format('M d, Y') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Time Schedule</p>
                <p class="font-medium text-gray-900">
                    {{ $program->start_time->format('h:i A') }} - {{ $program->end_time->format('h:i A') }}
                </p>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-sm text-gray-500 mb-2">Description</p>
            <div class="prose max-w-none text-gray-700">{!! nl2br(e($program->description)) !!}</div>
        </div>

        @if($program->allow_discussion)
        <div class="mt-6 flex items-center text-sm text-green-600">
            <i class='bx bx-message-rounded-check mr-2 text-xl'></i>
            Discussions are enabled for this program
        </div>
        @endif
    </div>

    <!-- Discussion Section -->
    @if($program->allow_discussion)
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold mb-6 flex items-center">
            <i class='bx bx-chat mr-2'></i> Discussion Thread
        </h3>
        
        <div class="space-y-6">
            @foreach($discussions as $discussion)
            <div class="flex items-start space-x-4 group">
                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                    {{ strtoupper(substr($discussion->user->firstname, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-medium text-gray-900">{{ $discussion->user->firstname }} {{$discussion->user->lastname }}</p>
                            <p class="text-sm text-gray-500">{{ $discussion->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <p class="text-gray-700">{{ $discussion->content }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $discussions->links() }}
        </div>
    </div>
    @endif
</div>
@endsection