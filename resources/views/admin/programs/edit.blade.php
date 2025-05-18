@extends('layouts.admin')

@section('title', 'Edit Program')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.programs.update', $program) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.programs.form')
        
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.programs.index') }}" 
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Program
            </button>
        </div>
    </form>
</div>
@endsection