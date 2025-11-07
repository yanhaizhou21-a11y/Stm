@extends('layouts.app')

@section('header', 'User Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-ocean-600 to-ocean-500 rounded-2xl shadow-xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-ocean-100 text-lg">Manage your school data efficiently with our modern interface</p>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Teachers Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-gradient-to-r from-ocean-500 to-ocean-400 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Teachers</p>
                    <p class="text-2xl font-bold text-ocean-600">{{ $teachersCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-gradient-to-r from-cyan-500 to-cyan-400 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Students</p>
                    <p class="text-2xl font-bold text-cyan-600">{{ $studentsCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-gradient-to-r from-blue-500 to-blue-400 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Categories</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $categoriesCount ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Inventory Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-gradient-to-r from-teal-500 to-teal-400 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Inventory Items</p>
                    <p class="text-2xl font-bold text-teal-600">{{ $inventoryCount ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Quick Actions -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('teachers.index') }}" class="group p-6 border-2 border-ocean-200 rounded-xl hover:border-ocean-500 hover:bg-ocean-50 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-ocean-100 rounded-lg group-hover:bg-ocean-200 transition-colors">
                                <svg class="w-6 h-6 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-800 group-hover:text-ocean-600">Manage Teachers</h4>
                                <p class="text-sm text-gray-600">Add, edit, and manage teacher records</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('students.index') }}" class="group p-6 border-2 border-cyan-200 rounded-xl hover:border-cyan-500 hover:bg-cyan-50 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-cyan-100 rounded-lg group-hover:bg-cyan-200 transition-colors">
                                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-800 group-hover:text-cyan-600">Manage Students</h4>
                                <p class="text-sm text-gray-600">Track and manage student information</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('categories.index') }}" class="group p-6 border-2 border-blue-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-800 group-hover:text-blue-600">Categories</h4>
                                <p class="text-sm text-gray-600">Organize inventory categories</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('inventories.index') }}" class="group p-6 border-2 border-teal-200 rounded-xl hover:border-teal-500 hover:bg-teal-50 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="p-3 bg-teal-100 rounded-lg group-hover:bg-teal-200 transition-colors">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-semibold text-gray-800 group-hover:text-teal-600">Inventory</h4>
                                <p class="text-sm text-gray-600">Manage school assets and equipment</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Your Profile</h3>
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-r from-ocean-500 to-ocean-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-800">{{ Auth::user()->name }}</h4>
                    <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
                    <div class="mt-4">
                        <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-ocean-600 to-ocean-500 text-white rounded-lg hover:from-ocean-700 hover:to-ocean-600 transition duration-200 text-sm font-medium">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            View Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Recent Activity</h3>
            <div class="space-y-4">
                <div class="flex items-center p-4 bg-ocean-50 rounded-lg">
                    <div class="p-2 bg-ocean-100 rounded-full">
                        <svg class="w-5 h-5 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-800">Welcome to the system!</p>
                        <p class="text-xs text-gray-600">You've successfully logged in to the School Management System</p>
                    </div>
                    <div class="ml-auto text-xs text-gray-500">Just now</div>
                </div>
                
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="p-2 bg-gray-100 rounded-full">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-800">System Ready</p>
                        <p class="text-xs text-gray-600">All modules are operational and ready for use</p>
                    </div>
                    <div class="ml-auto text-xs text-gray-500">1 min ago</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
