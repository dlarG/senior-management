@extends('layouts.admin')

@section('title', 'Edit Senior Citizen')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Senior Citizen</h2>
        
        <form action="{{ route('admin.seniors.update', $senior) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Personal Information -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-user-circle mr-2'></i> Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" name="firstname" value="{{ old('firstname', $senior->firstname) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                   placeholder="John">
                            @error('firstname')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                            <input type="text" name="middlename" value="{{ old('middlename', $senior->middlename) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                   placeholder="Middle">
                            @error('middlename')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" name="lastname" value="{{ old('lastname', $senior->lastname) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                   placeholder="Doe">
                            @error('lastname')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-lock-alt mr-2'></i> Account Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                            <input type="text" name="username" value="{{ old('username', $senior->username) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                   placeholder="john_doe">
                            @error('username')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value=""
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                   placeholder="Leave blank to keep current email">
                            @error('email')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                            <p class="text-xs text-gray-400 mt-1">Leave blank if you don't want to change the email.</p>
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-info-circle mr-2'></i> Status Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Birthdate *</label>
                            <input type="date" name="birthdate" 
                                   value="{{ old('birthdate', $senior->birthdate ? $senior->birthdate->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                   max="{{ now()->subYears(60)->format('Y-m-d') }}">
                            @error('birthdate')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                                <option value="active" {{ old('status', $senior->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="deceased" {{ old('status', $senior->status) === 'deceased' ? 'selected' : '' }}>Deceased</option>
                            </select>
                            @error('status')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('admin.seniors.index') }}" 
                       class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <i class='bx bx-save mr-2'></i> Update Senior
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection