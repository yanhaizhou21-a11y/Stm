@extends('layouts.app')

@section('header', 'Profile')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-ocean-600 to-ocean-500 rounded-xl shadow-lg p-6 text-dark mb-8">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="h-12 w-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <h1 class="text-3xl font-bold">Profile</h1>
                <p class="text-ocean-100 text-lg">Your account information</p>
            </div>
        </div>
    </div>

    <!-- Profile Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Profile Overview Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center">
                <!-- Profile Avatar -->
                <div class="mx-auto h-32 w-32 bg-gradient-to-r from-green-500 to-green-400 rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <svg class="h-16 w-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                
                <!-- User Name -->
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $user->name }}</h2>
                
                <!-- User Email -->
                <p class="text-gray-600 text-lg">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Account Details Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Account Details</h3>
            
            <div class="space-y-6">
                <!-- Full Name -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Full Name</p>
                        <p class="text-lg text-gray-900">{{ $user->name }}</p>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Email Address</p>
                        <p class="text-lg text-gray-900">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Account Created -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Account Created</p>
                        <p class="text-lg text-gray-900">{{ $user->created_at->format('F j, Y') }}</p>
                    </div>
                </div>

                <!-- Last Updated -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Last Updated</p>
                        <p class="text-lg text-gray-900">{{ $user->updated_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('profile.edit') }}" 
           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-ocean-600 to-ocean-500 text-white rounded-lg hover:from-ocean-700 hover:to-ocean-600 transition duration-200 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Profile
        </a>
        
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Dashboard
        </a>
    </div>
</div>
@endsection
