<div class="space-y-6 bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 gap-6 md:grid-cols-1">
        <div>
            <label class="block text-sm font-medium text-gray-700">Program Name *</label>
            <input style="height:40px;" type="text" name="name" value="{{ old('name', $program->name ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('name')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <div>
            <label class="block text-sm font-medium text-gray-700">Start Date *</label>
            <input type="date" name="start_date" 
                value="{{ old('start_date', $program->start_date ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('start_date')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>
    
        <div>
            <label class="block text-sm font-medium text-gray-700">Start Time *</label>
            <input type="time" name="start_time" 
                value="{{ old('start_time', $program->start_time ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('start_time')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>
    
        <div>
            <label class="block text-sm font-medium text-gray-700">End Time *</label>
            <input type="time" name="end_time" 
                value="{{ old('end_time', $program->end_time ?? '') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('end_time')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Description *</label>
        <textarea name="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $program->description ?? '') }}</textarea>
        @error('description')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="mt-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="allow_discussion" value="1" 
                {{ old('allow_discussion', $program->allow_discussion ?? false) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            <span class="ml-2 text-sm text-gray-600">Enable discussions for this program</span>
        </label>
    </div>
</div>