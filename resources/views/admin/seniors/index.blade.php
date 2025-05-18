@extends('layouts.admin')

@section('title', 'Manage Senior Citizens')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="flex items-center justify-between px-6 py-4 border-b">
        <h2 class="text-xl font-semibold">Senior Citizen Management</h2>
        <a href="{{ route('admin.seniors.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add New Senior
        </a>
    </div>

    <div class="px-6 py-4">
        <!-- Filter Controls -->
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <input type="text" id="searchInput" placeholder="Search by name, username, or email" 
                   class="w-full md:w-64 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            
            <select id="statusFilter" class="w-full md:w-48 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="deceased">Deceased</option>
            </select>
        </div>

        @if($seniors->isEmpty())
            <div class="text-gray-500 text-center py-8">No senior citizens found</div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="pb-3">Name</th>
                            <th class="pb-3">Username</th>
                            <th class="pb-3">Email</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="seniorsTable">
                        @foreach($seniors as $senior)
                        <tr class="border-b hover:bg-gray-50" data-status="{{ strtolower($senior->status) }}">
                            <td class="py-4">{{ $senior->firstname }} {{ $senior->middlename }} {{ $senior->lastname }}</td>
                            <td>{{ $senior->username }}</td>
                            <td>{{ $senior->email }}</td>
                            <td>
                                <span class="px-3 py-1 rounded-full text-sm 
                                    {{ $senior->status === 'active' ? 'bg-green-100 text-green-800' : 
                                       ($senior->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($senior->status) }}
                                </span>
                            </td>
                            <td class="space-x-3">
                                <a href="{{ route('admin.seniors.edit', $senior) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                <form action="{{ route('admin.seniors.destroy', $senior) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700" 
                                        onclick="return confirm('Are you sure you want to delete this senior?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const rows = document.querySelectorAll('#seniorsTable tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedStatus = statusFilter.value.toLowerCase();

        rows.forEach(row => {
            const name = row.cells[0].textContent.toLowerCase();
            const username = row.cells[1].textContent.toLowerCase();
            const email = row.cells[2].textContent.toLowerCase();
            const status = row.dataset.status;

            const matchesSearch = name.includes(searchTerm) || 
                                username.includes(searchTerm) || 
                                email.includes(searchTerm);
            
            const matchesStatus = selectedStatus === '' || status === selectedStatus;

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
});
</script>
@endsection