@extends('layouts.app')

@section('header', 'Edit Admin Profile')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-ocean-600 to-ocean-500 rounded-xl shadow-lg p-6 text-dark mb-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="h-12 w-12 rounded-full bg-white/20 flex items-center justify-center text-dark font-bold text-lg">
                    {{ substr($admin->name, 0, 1) }}
                </div>
            </div>
            <div class="ml-4">
                <h1 class="text-2xl font-bold">Edit Admin Profile</h1>
                <p class="text-ocean-100">{{ $admin->name }} ({{ $admin->username }})</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form action="{{ route('admins.update', $admin) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Username Field -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    Username <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="username" 
                       id="username" 
                       value="{{ old('username', $admin->username) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ocean-500 focus:border-ocean-500 transition duration-150 @error('username') border-red-500 @enderror"
                       placeholder="Enter username"
                       required>
                @error('username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $admin->name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ocean-500 focus:border-ocean-500 transition duration-150 @error('name') border-red-500 @enderror"
                       placeholder="Enter full name"
                       required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ old('email', $admin->email) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ocean-500 focus:border-ocean-500 transition duration-150 @error('email') border-red-500 @enderror"
                       placeholder="Enter email address"
                       required>
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Information Display -->
            <div class="bg-ocean-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-ocean-800 mb-3">Current Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-ocean-600 font-medium">Active Since:</span>
                        <p class="text-ocean-800">
                            {{ $admin->active_at ? $admin->active_at->format('M d, Y') : 'Not set' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-ocean-600 font-medium">Created:</span>
                        <p class="text-ocean-800">{{ $admin->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit" 
                        class="flex-1 sm:flex-none bg-gradient-to-r from-ocean-600 to-ocean-500 text-white px-6 py-3 rounded-lg hover:from-ocean-700 hover:to-ocean-600 transition duration-200 font-medium flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Profile
                </button>
                
                <a href="{{ route('admins.show', $admin) }}" 
                   class="flex-1 sm:flex-none bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition duration-200 font-medium flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
