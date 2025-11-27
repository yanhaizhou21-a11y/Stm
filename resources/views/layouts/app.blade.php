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
<body class="min-h-screen bg-slate-50 font-[Inter] text-slate-900 antialiased">
    <div class="min-h-screen flex">
        <x-layout.sidebar />

        <div class="flex-1 flex flex-col">
            <x-layout.topbar />

            <main class="flex-1 px-6 py-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Toast Container (managed by toast.js) -->
    <div id="toast-container"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggler = document.querySelector('[data-toggle-sidebar]');
            const sidebar = document.querySelector('[data-sidebar]');
            if (!toggler || !sidebar) {
                return;
            }

            const toggleSidebar = () => {
                sidebar.classList.toggle('-translate-x-full');
            };

            toggler.addEventListener('click', toggleSidebar);

            document.addEventListener('click', (event) => {
                if (!sidebar.contains(event.target) && !toggler.contains(event.target) && !sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        });
    </script>
    @stack('modals')
</body>
</html>