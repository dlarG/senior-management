@extends('layouts.admin')

@section('title', 'Manage Senior Citizens')

@section('content')
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="flex flex-col md:flex-row items-center justify-between px-6 py-4 border-b">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Senior Citizen Management</h2>
        <a href="{{ route('admin.seniors.create') }}" 
           class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
            <i class='bx bx-plus mr-2'></i> Add New Senior
        </a>
    </div>

    <div class="px-6 py-4">
        <!-- Filter Controls -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <input type="text" id="searchInput" placeholder="Search seniors..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                <i class='bx bx-search absolute left-3 top-3 text-gray-400 text-lg'></i>
            </div>
            
            <select id="statusFilter" class="w-full md:w-48 px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="deceased">Deceased</option>
            </select>
        </div>

        @if($seniors->isEmpty())
            <div class="text-center p-8">
                <div class="text-gray-400 text-2xl mb-2"><i class='bx bx-user-x'></i></div>
                <p class="text-gray-500">No senior citizens found</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-sm font-medium text-gray-500">
                            <th class="py-3.5 px-6">Name</th>
                            <th class="py-3.5 px-6">Contact</th>
                            <th class="py-3.5 px-6">Age</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="seniorsTable">
                        @foreach($seniors as $senior)
                        <tr class="hover:bg-gray-50 transition-colors" data-status="{{ strtolower($senior->status) }}">
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <i class='bx bx-user text-blue-600'></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $senior->firstname }} {{ $senior->lastname}}</div>
                                        <div class="text-sm text-gray-500">{{ $senior->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-gray-900">{{ $senior->email }}</div>
                                <div class="text-sm text-gray-500">{{ $senior->phone ?? 'N/A' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-gray-900">
                                    @if($senior->birthdate)
                                        {{ \Carbon\Carbon::parse($senior->birthdate)->age }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500">{{ $senior->birthdate?->format('M d, Y') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $senior->status === 'active' ? 'bg-green-100 text-green-800' : 
                                       ($senior->status === 'inactive' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    <span class="w-2 h-2 rounded-full mr-2 
                                        {{ $senior->status === 'active' ? 'bg-green-500' : 
                                           ($senior->status === 'inactive' ? 'bg-yellow-500' : 'bg-red-500') }}"></span>
                                    {{ ucfirst($senior->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 space-x-3">
                                <a href="{{ route('admin.seniors.edit', $senior) }}" 
                                   class="text-blue-600 hover:text-blue-800 p-2 rounded-md hover:bg-blue-50 transition-colors">
                                    <i class='bx bx-edit text-xl'></i>
                                </a>
                                <form action="{{ route('admin.seniors.destroy', $senior) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 p-2 rounded-md hover:bg-red-50 transition-colors"
                                            onclick="return confirm('Are you sure you want to delete this senior?')">
                                        <i class='bx bx-trash text-xl'></i>
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