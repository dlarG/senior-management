<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Senior Citizen Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white w-64 space-y-6 py-7 px-4 fixed h-full transition-all duration-300">
            <!-- Brand -->
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-blue-500 rounded-lg flex items-center justify-center">
                    <i class='bx bx-user-circle text-xl'></i>
                </div>
                <span class="text-xl font-semibold">SeniorCare</span>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <x-nav-link href="{{ route('senior.dashboard') }}" :active="request()->routeIs('senior.dashboard')">
                    <i class='bx bx-home-alt mr-3'></i> Dashboard
                </x-nav-link>
                <x-nav-link href="{{--{{ route('seniors.programs.index')}}" :active="request()->routeIs('seniors.programs.*')--}}#">
                    <i class='bx bx-calendar-event mr-3'></i> Programs
                </x-nav-link>
            </nav>

            <!-- Profile Section -->
            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gray-700 mt-auto">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        {{ strtoupper(substr(Auth::user()->firstname, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium">{{ Auth::user()->firstname }}</p>
                        <p class="text-sm text-gray-300">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-64">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <i class='bx bx-bell text-2xl text-gray-600'></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600">
                                <i class='bx bx-log-out'></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6">
                <!-- Notifications -->
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                    <div class="flex items-center">
                        <i class='bx bx-check-circle text-green-400 mr-2'></i>
                        <span class="text-sm">{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex items-center">
                        <i class='bx bx-error-circle text-red-400 mr-2'></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>