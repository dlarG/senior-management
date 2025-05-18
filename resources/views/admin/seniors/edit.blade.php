@extends('layouts.admin')

@section('title', 'Edit Senior Citizen')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('admin.seniors.update', $senior) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.seniors._form')
        
        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.seniors.index') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                Cancel
            </a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Update Senior Citizen
            </button>
        </div>
    </form>
</div>
@endsection