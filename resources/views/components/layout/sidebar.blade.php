@php
    $navigation = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3 9.75 10 3l7 6.75V17a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H4a1 1 0 01-1-1z'],
        ['label' => 'Teachers', 'route' => 'teachers.index', 'pattern' => 'teachers.*', 'icon' => 'M10 9a3 3 0 100-6 3 3 0 000 6zm-6 9a6 6 0 1112 0'],
        ['label' => 'Students', 'route' => 'students.index', 'pattern' => 'students.*', 'icon' => 'M6 8a3 3 0 11-6 0 3 3 0 016 0zm8 0a3 3 0 11-6 0 3 3 0 016 0zM4 14a4 4 0 00-4 4v1h8v-1a4 4 0 00-4-4zm8 5h8v-1a4 4 0 00-4-4h-2a4 4 0 00-4 4z'],
        ['label' => 'Categories', 'route' => 'categories.index', 'pattern' => 'categories.*', 'icon' => 'M3 5h14v4H3zm0 6h14v4H3z'],
        ['label' => 'Inventory', 'route' => 'inventories.index', 'pattern' => 'inventories.*', 'icon' => 'M4 6h12l-1 9H5z M8 6V4a2 2 0 114 0v2'],
        ['label' => 'Admins', 'route' => 'admins.index', 'pattern' => 'admins.*', 'icon' => 'M10 9a3 3 0 100-6 3 3 0 000 6zm-6 9a6 6 0 1112 0'],
        ['label' => 'Peminjaman', 'route' => 'peminjaman.index', 'pattern' => 'peminjaman.*', 'icon' => 'M6 2h8l3 4v10a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2 0 012-2z'],
        ['label' => 'Pengembalian', 'route' => 'pengembalian.index', 'pattern' => 'pengembalian.*', 'icon' => 'M4 4h12v2H4zm0 5h9v2H4zm0 5h12v2H4z'],
        ['label' => 'Laporan', 'route' => 'laporan.index', 'pattern' => 'laporan.*', 'icon' => 'M4 4h4v12H4zm6 4h4v8h-4zm6-6h4v14h-4z'],
        ['label' => 'Profile', 'route' => 'profile.show', 'pattern' => 'profile.*', 'icon' => 'M12 7a4 4 0 11-8 0 4 4 0 018 0zm-6 6a6 6 0 016 6H0a6 6 0 016-6z'],
    ];
@endphp

<aside class="fixed inset-y-0 z-30 w-64 -translate-x-full bg-white border-r border-slate-200 shadow-xl transition-transform duration-200 ease-out lg:translate-x-0 lg:flex lg:flex-col" data-sidebar>
    <div class="flex h-16 items-center px-6 border-b border-slate-200">
        <div>
            <p class="text-xs uppercase tracking-[0.2em] text-slate-400">School</p>
            <p class="text-lg font-semibold text-slate-900">Management</p>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-6 custom-scroll">
        <ul class="space-y-1 px-4">
            @foreach ($navigation as $item)
                @php
                    $isActive = request()->routeIs($item['pattern'] ?? $item['route']);
                @endphp
                <li>
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-medium transition {{ $isActive ? 'bg-indigo-100 text-indigo-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <path d="{{ $item['icon'] }}" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="hidden lg:block px-4 pb-6">
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">
                Logout
            </button>
        </form>
    </div>
</aside>

