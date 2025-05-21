@extends('layouts.senior')

@section('title', $program->name)

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h1 class="text-2xl font-bold">{{ $program->name }}</h1>
                <p class="text-gray-600 mt-1">
                    {{ $program->start_date->format('M d, Y') }} 
                    {{ $program->start_time->format('h:i A') }} - 
                    {{ $program->end_time->format('h:i A') }}
                </p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm 
                {{ $program->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                {{ ucfirst($program->status) }}
            </span>
        </div>

        <div class="prose max-w-none">
            {!! nl2br(e($program->description)) !!}
        </div>

        @if($program->allow_discussion)
        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-4">Discussion</h3>
            
            <form method="POST" action="{{ route('senior.programs.discussions.store', $program) }}">
                @csrf
                <textarea name="content" rows="3" 
                    class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Share your thoughts..."></textarea>
                <button type="submit" 
                    class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Post Comment
                </button>
            </form>

            <div class="mt-6 space-y-4">
                @foreach($discussions as $discussion)
                <div class="border-l-4 border-blue-200 pl-4 py-2">
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium">
                            {{ $discussion->user->firstname }} {{ $discussion->user->lastname }}
                        </span>
                        <span class="text-gray-500">
                            {{ $discussion->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="mt-1 text-gray-800">{{ $discussion->content }}</p>
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $discussions->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection