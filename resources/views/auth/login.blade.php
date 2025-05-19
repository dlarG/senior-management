<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Senior Citizen Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  @if(session('success'))
  <div id="toast" class="fixed top-5 right-5 flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 rounded-md shadow-lg transition-opacity duration-500 opacity-0">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span>{{ session('success') }}</span>
  </div>
  @endif
  <div class="bg-white shadow-md rounded-xl w-full max-w-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
      Senior Citizen Management System
    </h2>
    <form action="{{route('login_pro')}}" method="POST" class="space-y-5">
      @csrf
        <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Email or username</label>
        <input type="text" id="username" name="login" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>
      <div class="flex items-center justify-between">
        <label class="flex items-center text-sm">
          <input type="checkbox" class="mr-2" />
          Remember me
        </label>
        <a href="#" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
      </div>
      <button type="submit"
        class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
        Login
      </button>
    </form>
    <p class="text-center text-sm text-gray-500 mt-6">
      Don't have an account?
      <a href="/register" class="text-blue-600 hover:underline">Sign up</a>
    </p>
  </div>
  <script>
    // Show toast notification if exists
    document.addEventListener('DOMContentLoaded', function() {
      const toast = document.getElementById('toast');
      if (toast) {
        // Show toast
        setTimeout(() => toast.classList.add('opacity-100'), 100);
        
        // Hide toast after 5 seconds
        setTimeout(() => {
          toast.classList.remove('opacity-100');
          setTimeout(() => toast.remove(), 500);
        }, 5000);
      }
    });
  </script>
</body>
</html>