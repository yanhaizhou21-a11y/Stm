<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'School Management') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|poppins:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-cyan-50 to-blue-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0">
            <div class="h-full px-3 py-4 overflow-y-auto bg-gradient-to-b from-blue-600 to-cyan-600 shadow-xl">
                <div class="mb-8 px-4 py-6">
                    <h1 class="text-2xl font-bold text-white">School MS</h1>
                    <p class="text-blue-100 text-sm mt-1">Management System</p>
                </div>
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-white rounded-lg hover:bg-blue-500/50 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                            </svg>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('teachers.index') }}" class="flex items-center p-3 text-white rounded-lg hover:bg-blue-500/50 transition {{ request()->routeIs('teachers.*') ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                            <span class="ml-3">Teachers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('students.index') }}" class="flex items-center p-3 text-white rounded-lg hover:bg-blue-500/50 transition {{ request()->routeIs('students.*') ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                            <span class="ml-3">Students</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="flex items-center p-3 text-white rounded-lg hover:bg-blue-500/50 transition {{ request()->routeIs('categories.*') ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                            </svg>
                            <span class="ml-3">Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventories.index') }}" class="flex items-center p-3 text-white rounded-lg hover:bg-blue-500/50 transition {{ request()->routeIs('inventories.*') ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3">Inventory</span>
                        </a>
                    </li>
                    <li class="pt-4 mt-4 border-t border-blue-400">
                        <a href="{{ route('profile.edit') }}" class="flex items-center p-3 text-white rounded-lg hover:bg-blue-500/50 transition {{ request()->routeIs('profile.*') ? 'bg-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-3">Profile</span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full p-3 text-white rounded-lg hover:bg-red-500/50 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-3">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 sm:ml-64">
            <!-- Top Navbar -->
            <nav class="bg-gradient-to-r from-blue-600 to-cyan-500 shadow-lg">
                <div class="px-4 py-4">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-white">@yield('header', 'Dashboard')</h2>
                        <div class="flex items-center space-x-4">
                            <span class="text-white text-sm">{{ Auth::user()->name }}</span>
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    @stack('scripts')
</body>
</html>