@extends('layouts.app')

@section('header', 'Admin Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-ocean-600 to-ocean-500 rounded-xl shadow-lg p-6 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($admin->name, 0, 1) }}
                    </div>
                </div>
                <div class="ml-4">
                    <h1 class="text-2xl sm:text-3xl font-bold">{{ $admin->name }}</h1>
                    <p class="text-ocean-100">{{ $admin->username }}</p>
                </div>
            </div>
            <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-2">
                <a href="{{ route('admins.edit', $admin) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-ocean-600 rounded-lg hover:bg-ocean-50 transition duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Profile
                </a>
                <a href="{{ route('admins.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-ocean-500/20 text-white rounded-lg hover:bg-ocean-500/30 transition duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Profile Card -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile Information
                </h2>
                
                <div class="space-y-4 sm:space-y-6">
                    <!-- Username -->
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 mb-2 sm:mb-0">
                            <label class="text-sm font-medium text-gray-500">Username</label>
                        </div>
                        <div class="sm:w-2/3">
                            <div class="bg-ocean-50 px-4 py-3 rounded-lg">
                                <span class="text-ocean-800 font-medium">{{ $admin->username }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 mb-2 sm:mb-0">
                            <label class="text-sm font-medium text-gray-500">Full Name</label>
                        </div>
                        <div class="sm:w-2/3">
                            <div class="bg-ocean-50 px-4 py-3 rounded-lg">
                                <span class="text-ocean-800 font-medium">{{ $admin->name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 mb-2 sm:mb-0">
                            <label class="text-sm font-medium text-gray-500">Email Address</label>
                        </div>
                        <div class="sm:w-2/3">
                            <div class="bg-ocean-50 px-4 py-3 rounded-lg">
                                <span class="text-ocean-800 font-medium">{{ $admin->email }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 mb-2 sm:mb-0">
                            <label class="text-sm font-medium text-gray-500">Role</label>
                        </div>
                        <div class="sm:w-2/3">
                            <div class="bg-ocean-50 px-4 py-3 rounded-lg">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($admin->role === 'super_admin') bg-purple-100 text-purple-800
                                    @elseif($admin->role === 'admin') bg-blue-100 text-blue-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 mb-2 sm:mb-0">
                            <label class="text-sm font-medium text-gray-500">Status</label>
                        </div>
                        <div class="sm:w-2/3">
                            <div class="bg-ocean-50 px-4 py-3 rounded-lg">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($admin->status === 'active') bg-green-100 text-green-800
                                    @elseif($admin->status === 'inactive') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ ucfirst($admin->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Active Since -->
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 mb-2 sm:mb-0">
                            <label class="text-sm font-medium text-gray-500">Active Since</label>
                        </div>
                        <div class="sm:w-2/3">
                            <div class="bg-ocean-50 px-4 py-3 rounded-lg">
                                <span class="text-ocean-800 font-medium">
                                    {{ $admin->active_at ? $admin->active_at->format('F d, Y \a\t g:i A') : 'Not set' }}
                                </span>
                                @if($admin->active_at)
                                    <div class="text-xs text-ocean-600 mt-1">
                                        {{ $admin->active_at->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Created At -->
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 mb-2 sm:mb-0">
                            <label class="text-sm font-medium text-gray-500">Account Created</label>
                        </div>
                        <div class="sm:w-2/3">
                            <div class="bg-ocean-50 px-4 py-3 rounded-lg">
                                <span class="text-ocean-800 font-medium">
                                    {{ $admin->created_at->format('F d, Y \a\t g:i A') }}
                                </span>
                                <div class="text-xs text-ocean-600 mt-1">
                                    {{ $admin->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="sm:w-1/3 mb-2 sm:mb-0">
                            <label class="text-sm font-medium text-gray-500">Last Updated</label>
                        </div>
                        <div class="sm:w-2/3">
                            <div class="bg-ocean-50 px-4 py-3 rounded-lg">
                                <span class="text-ocean-800 font-medium">
                                    {{ $admin->updated_at->format('F d, Y \a\t g:i A') }}
                                </span>
                                <div class="text-xs text-ocean-600 mt-1">
                                    {{ $admin->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admins.edit', $admin) }}" 
                       class="w-full flex items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition duration-150">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>
                    
                    <form action="{{ route('admins.destroy', $admin) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-150"
                                onclick="return confirm('Are you sure you want to delete this admin? This action cannot be undone.')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete Admin
                        </button>
                    </form>
                </div>
            </div>

            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Account Status</h3>
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-3 w-3 rounded-full 
                            @if($admin->status === 'active') bg-green-400
                            @elseif($admin->status === 'inactive') bg-red-400
                            @else bg-yellow-400
                            @endif"></div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($admin->status) }}</p>
                        <p class="text-xs text-gray-500">
                            {{ $admin->active_at ? 'Since ' . $admin->active_at->format('M d, Y') : 'Status not set' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Admin ID Card -->
            <div class="bg-gradient-to-r from-ocean-50 to-ocean-100 rounded-xl p-6">
                <h3 class="text-lg font-bold text-ocean-800 mb-4">Admin ID</h3>
                <div class="text-2xl font-bold text-ocean-600">#{{ $admin->id }}</div>
                <p class="text-sm text-ocean-600 mt-1">Unique identifier</p>
            </div>
        </div>
    </div>
</div>
@endsection
