@extends('layouts.admin')

@section('title', $program->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Program Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">{{ $program->name }}</h1>
            <span class="px-3 py-1 rounded-full text-sm 
                  {{ $program->status === 'active' ? 'bg-green-100 text-green-800' : 
                     ($program->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                {{ ucfirst($program->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Start Date</p>
                <p>{{ \Carbon\Carbon::parse($program->start_date)->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-gray-500">End Date</p>
                <p>{{ \Carbon\Carbon::parse($program->end_date)->format('M d, Y') }}</p>
            </div>
        </div>

        <div class="mt-4">
            <p class="text-gray-500 mb-2">Description</p>
            <div class="prose max-w-none">{!! nl2br(e($program->description)) !!}</div>
        </div>

        @if($program->allow_discussion)
        <div class="mt-4 flex items-center text-sm text-green-600">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
            Discussions enabled
        </div>
        @endif
    </div>

    <!-- Discussion Section -->
    @if($program->allow_discussion)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Discussion Thread</h3>
        
        <!-- Discussion List -->
        <div class="space-y-4">
            @foreach($discussions as $discussion)
            <div class="border-l-4 border-blue-200 pl-4 py-2">
                <div class="flex items-center justify-between text-sm">
                    <span class="font-medium">{{ $discussion->user->firstname }} {{ $discussion->user->lastname }}</span>
                    <span class="text-gray-500">{{ $discussion->created_at->diffForHumans() }}</span>
                </div>
                <p class="mt-1 text-gray-800">{{ $discussion->content }}</p>
            </div>
            @endforeach
        </div>

        {{ $discussions->links() }}
    </div>
    @endif
</div>
@endsection