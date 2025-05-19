@extends('layouts.admin')

@section('title', 'Manage Programs')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b">
        <h2 class="text-xl font-semibold">Program Management</h2>
        <a href="{{ route('admin.programs.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Program
        </a>
    </div>

    <div class="px-6 py-4">
        @if($programs->isEmpty())
            <div class="text-gray-500 text-center py-8">No programs found</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-3">Program Name</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Start Date</th>
                            <th class="pb-3">Time</th>
                            <th class="pb-3">Discussions</th>
                            <th class="pb-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $program)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-4">{{ $program->name }}</td>
                            <td>
                                <span class="px-3 py-1 rounded-full text-sm 
                                    @switch($program->status)
                                        @case('active') bg-green-100 text-green-800 @break
                                        @case('successful') bg-purple-100 text-purple-800 @break
                                        @case('ended') bg-gray-100 text-gray-800 @break
                                        @default bg-blue-100 text-blue-800
                                    @endswitch">
                                    {{ ucfirst($program->status) }}
                                </span>
                            </td>
                            <td>
                                {{ $program->start_date->format('M d, Y') }}
                            </td>
                            <td>
                                {{ $program->start_time->format('h:i A') }} - 
                                {{ $program->end_time->format('h:i A') }}
                            </td>
                            <td>
                                @if($program->allow_discussion)
                                    <span class="text-green-500">✓ Enabled</span>
                                @else
                                    <span class="text-gray-400">✗ Disabled</span>
                                @endif
                            </td>
                            <td class="space-x-3">
                                <a href="{{ route('admin.programs.edit', $program) }}" 
                                   class="text-blue-500 hover:text-blue-700">
                                    Edit
                                </a>
                                <a href="{{ route('admin.programs.show', $program) }}" 
                                   class="text-gray-600 hover:text-gray-900">
                                    View
                                </a>
                                <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-500 hover:text-red-700"
                                            onclick="return confirm('Are you sure you want to delete this program?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                            <td>
                                @if($program->hasEnded())
                                    <form class="ml-2" method="POST" action="{{ route('admin.programs.mark-successful', $program) }}">
                                        @csrf
                                        <input type="checkbox" 
                                            class="success-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                            {{ $program->status === 'successful' ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                    </form>
                                    @else
                                    <span class="text-gray-400 text-sm">Ongoing</span>
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $programs->links() }}
            </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle checkbox submissions
        document.querySelectorAll('.success-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function(e) {
                e.preventDefault();
                
                const form = this.closest('form');
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: new FormData(form)
                })
                .then(response => {
                    if (!response.ok) throw new Error('Update failed');
                    location.reload(); // Refresh to update status
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.checked = !this.checked;
                });
            });
        });
    });
    </script>
@endpush
@endsection