<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Sign Up - Senior Citizen Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-xl w-full max-w-md p-8">
    @if ($errors->any())
    <div class="mb-4 text-red-600">
        <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
      Create an Account
    </h2>
    <form action="{{route('register_pro')}}" method="POST" class="space-y-5">
      @csrf
        <div>
        <label for="firstname" class="block text-sm font-medium text-gray-700">First Name</label>
        <input type="text" id="firstname" name="firstname" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>
      <div>
        <label for="middlename" class="block text-sm font-medium text-gray-700">Middle Name (optional)</label>
        <input type="text" id="middlename" name="middlename"
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>
      <div>
        <label for="lastname" class="block text-sm font-medium text-gray-700">Last Name</label>
        <input type="text" id="lastname" name="lastname" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" id="username" name="username" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" id="password" name="password" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>
      <div>
        <label for="confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
        <input type="password" id="confirm" name="password_confirmation" required
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" />
      </div>
      <input type="hidden" name="roleType" value="senior">
      <button type="submit"
        class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300">
        Sign Up
      </button>
    </form>
    <p class="text-center text-sm text-gray-500 mt-6">
      Already have an account?
      <a href="/login" class="text-blue-600 hover:underline">Login</a>
    </p>
  </div>
</body>
</html>
