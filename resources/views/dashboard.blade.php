@extends('layouts.app')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Teachers Card -->
    <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Teachers</p>
                <h3 class="text-4xl font-bold mt-2">{{ $stats['teachers'] }}</h3>
                <p class="text-blue-100 text-xs mt-2">Active teachers</p>
            </div>
            <div class="bg-white/20 p-3 rounded-xl">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Students Card -->
    <div class="bg-gradient-to-br from-cyan-500 to-blue-400 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-cyan-100 text-sm font-medium">Total Students</p>
                <h3 class="text-4xl font-bold mt-2">{{ $stats['students'] }}</h3>
                <p class="text-cyan-100 text-xs mt-2">Active students</p>
            </div>
            <div class="bg-white/20 p-3 rounded-xl">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Inventory Card -->
    <div class="bg-gradient-to-br from-blue-600 to-cyan-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-blue-100 text-sm font-medium">Inventory Items</p>
                <h3 class="text-4xl font-bold mt-2">{{ $stats['inventories'] }}</h3>
                <p class="text-blue-100 text-xs mt-2">Total items</p>
            </div>
            <div class="bg-white/20 p-3 rounded-xl">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Categories Card -->
    <div class="bg-gradient-to-br from-cyan-600 to-blue-500 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-cyan-100 text-sm font-medium">Categories</p>
                <h3 class="text-4xl font-bold mt-2">{{ $stats['categories'] }}</h3>
                <p class="text-cyan-100 text-xs mt-2">Item categories</p>
            </div>
            <div class="bg-white/20 p-3 rounded-xl">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="bg-white rounded-2xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome to School Management System</h2>
    <p class="text-gray-600 leading-relaxed">
        Manage your school's teachers, students, and inventory efficiently with our modern management system. 
        Navigate through the sidebar to access different modules and manage your data effectively.
    </p>
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('teachers.index') }}" class="p-4 border-2 border-blue-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition">
            <h3 class="font-semibold text-blue-600">Manage Teachers</h3>
            <p class="text-sm text-gray-600 mt-1">Add, edit, and manage teacher records</p>
        </a>
        <a href="{{ route('students.index') }}" class="p-4 border-2 border-cyan-200 rounded-xl hover:border-cyan-500 hover:bg-cyan-50 transition">
            <h3 class="font-semibold text-cyan-600">Manage Students</h3>
            <p class="text-sm text-gray-600 mt-1">Track and manage student information</p>
        </a>
        <a href="{{ route('inventories.index') }}" class="p-4 border-2 border-blue-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition">
            <h3 class="font-semibold text-blue-600">Inventory Control</h3>
            <p class="text-sm text-gray-600 mt-1">Manage school assets and equipment</p>
        </a>
    </div>
</div>
@endsection