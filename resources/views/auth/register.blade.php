<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Sign Up - Senior Citizen Management System</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center min-h-screen p-4">
  <div class="bg-white shadow-2xl rounded-2xl w-full max-w-md p-8 transition-all duration-300 hover:shadow-3xl">
    @if ($errors->any())
    <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          @foreach ($errors->all() as $error)
            <p class="text-sm text-red-700">{{ $error }}</p>
          @endforeach
        </div>
      </div>
    </div>
    @endif
    
    <div class="text-center mb-8">
      <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Join Our Community</h1>
      <p class="text-gray-500">Create your account in minutes</p>
    </div>

    <form action="{{route('register_pro')}}" method="POST" class="space-y-6">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">First Name <span class="text-red-500">*</span></label>
          <input type="text" name="firstname" required
            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
          <input type="text" name="middlename"
            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Last Name <span class="text-red-500">*</span></label>
        <input type="text" name="lastname" required
          class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Birthdate <span class="text-red-500">*</span></label>
        <input type="date" name="birthdate" required max="{{ now()->subYears(60)->format('Y-m-d') }}"
          class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none">
        <p class="mt-1 text-sm text-gray-500">Must be at least 60 years old</p>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
        <input type="email" name="email" required
          class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
        <input type="text" name="username" required
          class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none">
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
          <input type="password" name="password" required
            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
          <input type="password" name="password_confirmation" required
            class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none">
        </div>
      </div>

      <input type="hidden" name="roleType" value="senior">
      
      <button type="submit"
        class="w-full py-3.5 px-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-[1.02]">
        Create Account
      </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-8">
      Already have an account?
      <a href="/login" class="font-semibold text-blue-600 hover:text-blue-700 hover:underline">Sign in here</a>
    </p>
  </div>
</body>
</html>