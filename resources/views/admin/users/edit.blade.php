@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden max-w-2xl mx-auto">
    <div class="px-6 py-4 border-b">
        <h2 class="text-xl font-semibold">Edit User</h2>
    </div>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Same fields as create form but with existing values -->
            <div>
                <label class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="firstname" value="{{ $user->firstname }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                <input type="text" name="middlename" value="{{ $user->middlename }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="lastname" value="{{ $user->lastname }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" value="{{ $user->username }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">New Password</label>
                <input type="password" name="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <select name="roleType" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="admin" {{ $user->roleType === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="senior" {{ $user->roleType === 'senior' ? 'selected' : '' }}>Senior</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="deceased" {{ $user->status === 'deceased' ? 'selected' : '' }}>Deceased</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.users.index') }}"
                class="px-4 py-2 border rounded-md hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Update User
            </button>
        </div>
    </form>
</div>
@endsection