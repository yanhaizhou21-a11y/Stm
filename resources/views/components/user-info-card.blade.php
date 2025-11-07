<!-- User Information Card Component -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <!-- Card Header -->
    <div class="bg-gradient-to-r from-ocean-600 to-ocean-500 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                    @if(isset($icon))
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                        </svg>
                    @else
                        <span class="text-lg font-bold text-white">{{ substr($title, 0, 1) }}</span>
                    @endif
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-semibold text-white">{{ $title }}</h3>
                    @if(isset($subtitle))
                        <p class="text-ocean-100 text-sm">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            @if(isset($badge))
                <span class="px-3 py-1 bg-white/20 text-white text-xs font-medium rounded-full">
                    {{ $badge }}
                </span>
            @endif
        </div>
    </div>

    <!-- Card Content -->
    <div class="p-6">
        @if(isset($description))
            <p class="text-gray-600 mb-4">{{ $description }}</p>
        @endif

        @if(isset($stats) && is_array($stats))
            <div class="grid grid-cols-2 gap-4 mb-6">
                @foreach($stats as $stat)
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-ocean-600">{{ $stat['value'] }}</div>
                        <div class="text-sm text-gray-600">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(isset($items) && is_array($items))
            <div class="space-y-3">
                @foreach($items as $item)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center">
                            @if(isset($item['icon']))
                                <div class="w-8 h-8 {{ $item['icon_bg'] ?? 'bg-ocean-100' }} rounded-full flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 {{ $item['icon_color'] ?? 'text-ocean-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $item['label'] }}</p>
                                @if(isset($item['description']))
                                    <p class="text-xs text-gray-500">{{ $item['description'] }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ $item['value'] }}</p>
                            @if(isset($item['sub_value']))
                                <p class="text-xs text-gray-500">{{ $item['sub_value'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if(isset($actions) && is_array($actions))
            <div class="mt-6 space-y-2">
                @foreach($actions as $action)
                    <a href="{{ $action['url'] }}" class="w-full inline-flex items-center justify-center px-4 py-2 {{ $action['class'] ?? 'bg-gradient-to-r from-ocean-600 to-ocean-500 text-white hover:from-ocean-700 hover:to-ocean-600' }} rounded-lg transition duration-200 font-medium text-sm">
                        @if(isset($action['icon']))
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/>
                            </svg>
                        @endif
                        {{ $action['text'] }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Card Footer -->
    @if(isset($footer))
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    {{ $footer['text'] }}
                </div>
                @if(isset($footer['action']))
                    <a href="{{ $footer['action']['url'] }}" class="text-sm font-medium text-ocean-600 hover:text-ocean-500">
                        {{ $footer['action']['text'] }}
                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>
