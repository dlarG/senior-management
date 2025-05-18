<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Senior Citizen Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-blue-800 text-white w-64 space-y-6 py-7 px-2 inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out fixed md:relative">
            <div class="text-white flex items-center space-x-2 px-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="text-xl font-bold">Senior Care</span>
            </div>
            <nav>
                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    Dashboard
                </x-nav-link>
                <x-nav-link href="{{ route('admin.seniors.index')}}" :active="request()->routeIs('admin.seniors.*')">
                    Manage Seniors
                </x-nav-link>
                <x-nav-link href="{{ route('admin.programs.index')}}" :active="request()->routeIs('admin.programs.*')">
                    Programs
                </x-nav-link>
                <x-nav-link href="#">
                    Users
                </x-nav-link>
                <x-nav-link href="#">
                    Reports
                </x-nav-link>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 py-4">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome, {{ Auth::user()->firstname }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-blue-600">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Message -->
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>