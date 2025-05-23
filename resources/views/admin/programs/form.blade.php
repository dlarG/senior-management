<div class="space-y-8">
    <!-- Program Details -->
    <div class="bg-gray-50 p-6 rounded-xl">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class='bx bx-detail mr-2'></i> Program Details
        </h3>
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Program Name *</label>
                <input type="text" name="name" value="{{ old('name', $program->name ?? '') }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                       placeholder="Enter program name">
                @error('name')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="4"
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all"
                          placeholder="Describe the program details">{{ old('description', $program->description ?? '') }}</textarea>
                @error('description')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <!-- Schedule Details -->
    <div class="bg-gray-50 p-6 rounded-xl">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class='bx bx-time-five mr-2'></i> Schedule Details
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                <input type="date" name="start_date" 
                       value="{{ old('start_date', isset($program) ? $program->start_date->format('Y-m-d') : '') }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                @error('start_date')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Time *</label>
                <input type="time" name="start_time" 
                       value="{{ old('start_time', isset($program) ? $program->start_time->format('H:i') : '') }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                @error('start_time')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Time *</label>
                <input type="time" name="end_time" 
                       value="{{ old('end_time', isset($program) ? $program->end_time->format('H:i') : '') }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                @error('end_time')<p class="mt-1 text-red-500 text-sm">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <!-- Additional Settings -->
    <div class="bg-gray-50 p-6 rounded-xl">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <i class='bx bx-cog mr-2'></i> Additional Settings
        </h3>
        <div class="space-y-4">
            <label class="flex items-center space-x-3">
                <input type="checkbox" name="allow_discussion" value="1" 
                    {{ old('allow_discussion', $program->allow_discussion ?? false) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="text-sm text-gray-700">Enable discussions for this program</span>
            </label>
        </div>
    </div>
</div>