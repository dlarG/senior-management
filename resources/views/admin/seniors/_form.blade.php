<div class="space-y-6 bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div>
            <label class="block text-sm font-medium text-gray-700">First Name *</label>
            <input type="text" name="firstname" value="{{ old('firstname', $senior->firstname ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('firstname')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Middle Name</label>
            <input type="text" name="middlename" value="{{ old('middlename', $senior->middlename ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('middlename')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Last Name *</label>
            <input type="text" name="lastname" value="{{ old('lastname', $senior->lastname ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('lastname')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700">Username *</label>
            <input type="text" name="username" value="{{ old('username', $senior->username ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('username')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Email *</label>
            <input type="email" name="email" value="{{ old('email', $senior->email ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('email')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>
    </div>

    @if(!isset($senior))
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700">Password *</label>
            <input type="password" name="password" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('password')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Confirm Password *</label>
            <input type="password" name="password_confirmation" 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>
    @endif
    <div>
        <label class="block text-sm font-medium text-gray-700">Birthdate *</label>
        <input type="date" name="birthdate" 
               value="{{ old('birthdate', isset($senior) ? $senior->birthdate?->format('Y-m-d') : '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
               max="{{ now()->subYears(60)->format('Y-m-d') }}">
        @error('birthdate')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Status *</label>
        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="active" {{ old('status', $senior->status ?? '') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="deceased" {{ old('status', $senior->status ?? '') === 'deceased' ? 'selected' : '' }}>Deceased</option>
        </select>
        @error('status')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>
</div>