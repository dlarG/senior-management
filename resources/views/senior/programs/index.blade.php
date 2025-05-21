@extends('layouts.senior')

@section('title', 'Programs')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Available Programs</h1>
        
        <div class="grid grid-cols-1 gap-4">
            @foreach($programs as $program)
            <div class="border rounded-lg p-4 hover:bg-gray-50">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-semibold">{{ $program->name }}</h3>
                        <p class="text-gray-600 mt-1">
                            {{ $program->start_date->format('M d, Y') }} 
                            {{ $program->start_time->format('h:i A') }} - 
                            {{ $program->end_time->format('h:i A') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 text-sm rounded-full 
                            {{ $program->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($program->status) }}
                        </span>
                        @if($program->allow_discussion)
                            <span class="px-2 py-1 text-sm rounded-full bg-purple-100 text-purple-800">
                                Open for Discussion
                            </span>
                        @endif
                    </div>
                </div>
                <p class="mt-2 text-gray-700">{{ Str::limit($program->description, 150) }}</p>
                <a href="{{ route('senior.programs.show', $program) }}" 
                   class="mt-3 inline-block text-blue-500 hover:text-blue-700">
                    View Details →
                </a>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $programs->links() }}
        </div>
    </div>
</div>
@endsection