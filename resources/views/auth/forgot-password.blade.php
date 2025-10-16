<x-guest-layout>
    <div class="min-h-screen ocean-pattern flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Logo & Title -->
            <div class="text-center mb-8 float-animation">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-2xl mb-4">
                    <svg class="w-10 h-10 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">Reset Password</h1>
                <p class="text-blue-100 text-lg">We'll send you a reset link</p>
            </div>

            <!-- Forgot Password Card -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8">
                <div class="mb-6 text-sm text-gray-600">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707