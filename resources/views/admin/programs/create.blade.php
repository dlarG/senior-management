@extends('layouts.admin')

@section('title', 'Create New Program')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.programs.store') }}" method="POST">
        @csrf
        @include('admin.programs.form')
        
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.programs.index') }}" 
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Program
            </button>
        </div>
    </form>
</div>
@endsection