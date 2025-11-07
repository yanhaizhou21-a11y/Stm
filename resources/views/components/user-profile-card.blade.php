<!-- User Profile Card Component -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="bg-gradient-to-r from-ocean-600 to-ocean-500 px-6 py-8">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                    <span class="text-2xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-xl font-bold text-white">{{ $user->name }}</h3>
                <p class="text-ocean-100">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="p-6">
        <!-- User Stats -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="text-center p-4 bg-ocean-50 rounded-lg">
                <div class="text-2xl font-bold text-ocean-600">{{ $user->created_at->format('d') }}</div>
                <div class="text-sm text-gray-600">{{ $user->created_at->format('M Y') }}</div>
                <div class="text-xs text-gray-500">Member Since</div>
            </div>
            <div class="text-center p-4 bg-cyan-50 rounded-lg">
                <div class="text-2xl font-bold text-cyan-600">{{ $user->updated_at->diffInDays() }}</div>
                <div class="text-sm text-gray-600">Days Ago</div>
                <div class="text-xs text-gray-500">Last Active</div>
            </div>
        </div>

        <!-- User Info -->
        <div class="space-y-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-8 h-8 bg-ocean-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-ocean-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Full Name</p>
                    <p class="text-sm text-gray-500">{{ $user->name }}</p>
                </div>
            </div>

            <div class="flex items-center">
                <div class="flex-shrink-0 w-8 h-8 bg-cyan-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Email Address</p>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>

            <div class="flex items-center">
                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Account Created</p>
                    <p class="text-sm text-gray-500">{{ $user->created_at->format('F j, Y') }}</p>
                </div>
            </div>

            <div class="flex items-center">
                <div class="flex-shrink-0 w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Last Updated</p>
                    <p class="text-sm text-gray-500">{{ $user->updated_at->format('F j, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 space-y-3">
            <a href="{{ route('profile.edit') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-ocean-600 to-ocean-500 text-white rounded-lg hover:from-ocean-700 hover:to-ocean-600 transition duration-200 font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Profile
            </a>
            
            <a href="{{ route('dashboard') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 font-medium">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
