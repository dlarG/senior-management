<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Senior Citizen Management System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center min-h-screen p-4">
  @if(session('success'))
  <div id="toast" class="fixed top-5 right-5 flex items-center bg-green-500 text-white text-sm font-bold px-4 py-3 rounded-md shadow-lg transition-opacity duration-500 opacity-0">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span>{{ session('success') }}</span>
  </div>
  @endif

  <div class="bg-white shadow-2xl rounded-2xl w-full max-w-md p-8 transition-all duration-300 hover:shadow-3xl">
    <div class="text-center mb-10">
      <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Welcome Back</h1>
      <p class="text-gray-500">Sign in to your account</p>
    </div>

    <form action="{{route('login_pro')}}" method="POST" class="space-y-6">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Email or Username <span class="text-red-500">*</span></label>
        <input type="text" name="login" required
          class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none"
          placeholder="Enter your email or username">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
        <input type="password" name="password" required
          class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition duration-300 outline-none"
          placeholder="Enter your password">
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center text-sm text-gray-600">
          <input type="checkbox" class="w-4 h-4 mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
          Remember me
        </label>
        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 hover:underline">Forgot password?</a>
      </div>

      <button type="submit"
        class="w-full py-3.5 px-6 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-[1.02]">
        Sign In
      </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-8">
      Don't have an account?
      <a href="/register" class="font-semibold text-blue-600 hover:text-blue-700 hover:underline">Create account</a>
    </p>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const toast = document.getElementById('toast');
      if (toast) {
        setTimeout(() => toast.classList.add('opacity-100'), 100);
        setTimeout(() => {
          toast.classList.remove('opacity-100');
          setTimeout(() => toast.remove(), 500);
        }, 5000);
      }
    });
  </script>
</body>
</html>