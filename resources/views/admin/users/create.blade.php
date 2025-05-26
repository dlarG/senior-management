@extends('layouts.admin')

@section('title', 'Create New User')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New User</h2>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- Personal Info -->
            <div class="bg-gray-50 p-6 rounded-xl mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class='bx bx-user-circle mr-2'></i> Personal Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
                        <input type="text" name="firstname" value="{{ old('firstname') }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        @error('firstname')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                        <input type="text" name="middlename" value="{{ old('middlename') }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        @error('middlename')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
                        <input type="text" name="lastname" value="{{ old('lastname') }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        @error('lastname')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <!-- Account Info -->
            <div class="bg-gray-50 p-6 rounded-xl mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class='bx bx-lock-alt mr-2'></i> Account Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Username *</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        @error('username')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                        @error('email')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                               placeholder="Enter password">
                        <button type="button" onclick="togglePassword(this, 'password')" 
                                class="absolute right-3 top-9 text-gray-400 hover:text-gray-600">
                            <i class='bx bx-hide'></i>
                        </button>
                        @error('password')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                               class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                               placeholder="Confirm password">
                        <button type="button" onclick="togglePassword(this, 'password_confirmation')" 
                                class="absolute right-3 top-9 text-gray-400 hover:text-gray-600">
                            <i class='bx bx-hide'></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Permissions -->
            <div class="bg-gray-50 p-6 rounded-xl mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class='bx bx-cog mr-2'></i> Permissions
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                        <select name="roleType" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="admin" {{ old('roleType') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ old('roleType') === 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="senior" {{ old('roleType') === 'senior' ? 'selected' : '' }}>Senior</option>
                        </select>
                        @error('roleType')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="deceased" {{ old('status') === 'deceased' ? 'selected' : '' }}>Deceased</option>
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
                    <i class='bx bx-user-plus mr-2'></i> Create User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(button, inputId) {
    const input = document.getElementById(inputId);
    const type = input.type === 'password' ? 'text' : 'password';
    input.type = type;
    button.innerHTML = type === 'password' ? '<i class="bx bx-hide"></i>' : '<i class="bx bx-show"></i>';
}
</script>
@endsection