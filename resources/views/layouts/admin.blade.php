<!-- layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Senior Citizen Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="h-full bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-gray-900 text-white w-64 space-y-6 py-7 px-4 fixed h-full transition-all duration-300 transform -translate-x-full lg:translate-x-0 z-[999]" style="height: 100%;">
            <!-- Brand -->
            <div class="flex items-center justify-between px-2">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class='bx bx-user-circle text-xl'></i>
                    </div>
                    <span class="text-xl font-semibold">SeniorCare</span>
                </div>
                <button id="sidebarClose" class="lg:hidden text-gray-400 hover:text-white">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1">
                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                    <i class='bx bx-home-alt mr-3'></i> Dashboard
                </x-nav-link>
                <x-nav-link href="{{ route('admin.seniors.index')}}" :active="request()->routeIs('admin.seniors.*')">
                    <i class='bx bx-group mr-3'></i> Manage Seniors
                </x-nav-link>
                <x-nav-link href="{{ route('admin.programs.index')}}" :active="request()->routeIs('admin.programs.*')">
                    <i class='bx bx-calendar-event mr-3'></i> Programs
                </x-nav-link>
                <x-nav-link href="{{ route('admin.users.index')}}" :active="request()->routeIs('admin.users.*')">
                    <i class='bx bx-user-pin mr-3'></i> Users
                </x-nav-link>
                <x-nav-link href="{{ route('admin.reports.index')}}" :active="request()->routeIs('admin.reports.index')">
                    <i class='bx bx-line-chart mr-3'></i> Reports
                </x-nav-link>
            </nav>

            <!-- Profile Section -->
            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gray-800 mt-auto">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                        {{ strtoupper(substr(Auth::user()->firstname, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-medium truncate">{{ Auth::user()->firstname }}</p>
                        <p class="text-sm text-gray-400">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Header -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <button id="sidebarToggle" class="lg:hidden text-gray-600 hover:text-gray-800">
                            <i class='bx bx-menu text-2xl'></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>
                    </div>
                    <div class="flex items-center space-x-6">
                        <div class="relative group">
                            <button class="text-gray-600 hover:text-gray-800 relative">
                                <i class='bx bx-bell text-2xl'></i>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            <!-- Notifications Dropdown -->
                            <div class="hidden group-hover:block absolute right-0 mt-2 w-64 bg-white shadow-xl rounded-lg border border-gray-100">
                                <div class="p-4 text-sm text-gray-600">No new notifications</div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors">
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
                {{-- @include('partials.notifications') --}}

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        sidebarClose.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });

        // Responsive Sidebar
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>