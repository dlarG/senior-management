@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit User</h2>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                {{ strtoupper(substr($user->firstname, 0, 1)) }}
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Personal Info -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-user-circle mr-2'></i> Personal Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                            <input type="text" name="firstname" value="{{ old('firstname', $user->firstname) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            @error('firstname')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                            <input type="text" name="middlename" value="{{ old('middlename', $user->middlename) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            @error('middlename')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                            <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            @error('lastname')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-lock-alt mr-2'></i> Account Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            @error('username')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            @error('email')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                            <input type="password" name="password"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                   placeholder="Leave blank to keep current password">
                            @error('password')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                                   placeholder="Confirm new password">
                        </div>
                    </div>
                </div>

                <!-- Permissions -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-cog mr-2'></i> Permissions
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                            <select name="roleType" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                                <option value="admin" {{ old('roleType', $user->roleType) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="staff" {{ old('roleType', $user->roleType) === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="senior" {{ old('roleType', $user->roleType) === 'senior' ? 'selected' : '' }}>Senior</option>
                            </select>
                            @error('roleType')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                                <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="deceased" {{ old('status', $user->status) === 'deceased' ? 'selected' : '' }}>Deceased</option>
                            </select>
                            @error('status')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-2.5 border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                        <i class='bx bx-save mr-2'></i> Update User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection