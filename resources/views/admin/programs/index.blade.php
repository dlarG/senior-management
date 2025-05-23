@extends('layouts.admin')

@section('title', 'Manage Programs')

@section('content')
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="flex flex-col md:flex-row items-center justify-between px-6 py-4 border-b">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Program Management</h2>
        <a href="{{ route('admin.programs.create') }}" 
           class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
            <i class='bx bx-plus mr-2'></i> New Program
        </a>
    </div>

    <div class="px-6 py-4">
        @if($programs->isEmpty())
            <div class="text-center p-8">
                <div class="text-gray-400 text-2xl mb-2"><i class='bx bx-calendar-event'></i></div>
                <p class="text-gray-500">No programs found</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-sm font-medium text-gray-500">
                            <th class="py-3.5 px-6">Program</th>
                            <th class="py-3.5 px-6">Schedule</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6">Discussions</th>
                            <th class="py-3.5 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($programs as $program)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                        <i class='bx bx-calendar text-blue-600'></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $program->name }}</div>
                                        <div class="text-sm text-gray-500 line-clamp-1">{{ $program->description }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-gray-900">{{ $program->start_date->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ $program->start_time->format('h:i A') }} - {{ $program->end_time->format('h:i A') }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @switch($program->status)
                                            @case('active') bg-green-100 text-green-800 @break
                                            @case('successful') bg-purple-100 text-purple-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                        {{ ucfirst($program->status) }}
                                    </span>
                                    @if($program->hasEnded())
                                    <form class="ml-3" method="POST" action="{{ route('admin.programs.mark-successful', $program) }}">
                                        @csrf
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                class="success-checkbox sr-only peer"
                                                {{ $program->status === 'successful' ? 'checked' : '' }}>
                                            <div class="w-9 h-5 bg-gray-200 rounded-full transition-colors peer-checked:bg-blue-600"></div>
                                            <div class="absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition-transform peer-checked:translate-x-4"></div>
                                        </label>
                                    </form>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($program->allow_discussion)
                                    <i class='bx bx-message-rounded-check text-green-600 text-xl'></i>
                                @else
                                    <i class='bx bx-message-rounded-x text-gray-400 text-xl'></i>
                                @endif
                            </td>
                            <td class="py-4 px-6 space-x-3">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.programs.edit', $program) }}" 
                                       class="text-blue-600 hover:text-blue-800 p-2 rounded-md hover:bg-blue-50 transition-colors">
                                        <i class='bx bx-edit text-xl'></i>
                                    </a>
                                    <a href="{{ route('admin.programs.show', $program) }}" 
                                       class="text-gray-600 hover:text-gray-800 p-2 rounded-md hover:bg-gray-50 transition-colors">
                                        <i class='bx bx-show text-xl'></i>
                                    </a>
                                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 p-2 rounded-md hover:bg-red-50 transition-colors"
                                                onclick="return confirm('Are you sure you want to delete this program?')">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
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