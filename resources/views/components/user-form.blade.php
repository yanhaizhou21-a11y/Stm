<!-- User Form Component -->
<div class="bg-white rounded-xl shadow-lg p-8">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ $title ?? 'Form' }}</h3>
        <p class="text-gray-600">{{ $description ?? 'Please fill in the required information below.' }}</p>
    </div>

    <form method="{{ $method ?? 'POST' }}" action="{{ $action ?? '#' }}" class="space-y-6">
        @csrf
        @if(isset($method) && $method !== 'POST')
            @method($method)
        @endif

        <!-- Form Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($fields as $field)
                <div class="space-y-2">
                    <label for="{{ $field['name'] }}" class="block text-sm font-medium text-gray-700">
                        {{ $field['label'] }}
                        @if(isset($field['required']) && $field['required'])
                            <span class="text-red-500">*</span>
                        @endif
                    </label>
                    
                    @if($field['type'] === 'text' || $field['type'] === 'email' || $field['type'] === 'password')
                        <input 
                            type="{{ $field['type'] }}" 
                            name="{{ $field['name'] }}" 
                            id="{{ $field['name'] }}" 
                            value="{{ old($field['name'], $field['value'] ?? '') }}"
                            placeholder="{{ $field['placeholder'] ?? '' }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ocean-500 focus:border-ocean-500 transition duration-200 @error($field['name']) border-red-500 @enderror"
                            @if(isset($field['required']) && $field['required']) required @endif
                        >
                    @elseif($field['type'] === 'textarea')
                        <textarea 
                            name="{{ $field['name'] }}" 
                            id="{{ $field['name'] }}" 
                            rows="{{ $field['rows'] ?? 3 }}"
                            placeholder="{{ $field['placeholder'] ?? '' }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ocean-500 focus:border-ocean-500 transition duration-200 @error($field['name']) border-red-500 @enderror"
                            @if(isset($field['required']) && $field['required']) required @endif
                        >{{ old($field['name'], $field['value'] ?? '') }}</textarea>
                    @elseif($field['type'] === 'select')
                        <select 
                            name="{{ $field['name'] }}" 
                            id="{{ $field['name'] }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ocean-500 focus:border-ocean-500 transition duration-200 @error($field['name']) border-red-500 @enderror"
                            @if(isset($field['required']) && $field['required']) required @endif
                        >
                            <option value="">{{ $field['placeholder'] ?? 'Select an option' }}</option>
                            @foreach($field['options'] as $value => $label)
                                <option value="{{ $value }}" {{ old($field['name'], $field['value'] ?? '') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    @elseif($field['type'] === 'checkbox')
                        <div class="flex items-center">
                            <input 
                                type="checkbox" 
                                name="{{ $field['name'] }}" 
                                id="{{ $field['name'] }}" 
                                value="1"
                                {{ old($field['name'], $field['value'] ?? false) ? 'checked' : '' }}
                                class="h-4 w-4 text-ocean-600 focus:ring-ocean-500 border-gray-300 rounded"
                            >
                            <label for="{{ $field['name'] }}" class="ml-2 block text-sm text-gray-700">
                                {{ $field['label'] }}
                            </label>
                        </div>
                    @endif

                    @error($field['name'])
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
            <button type="submit" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-ocean-600 to-ocean-500 text-white rounded-lg hover:from-ocean-700 hover:to-ocean-600 transition duration-200 font-medium">
                @if(isset($submitIcon))
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $submitIcon }}"/>
                    </svg>
                @endif
                {{ $submitText ?? 'Save Changes' }}
            </button>
            
            @if(isset($cancelUrl))
                <a href="{{ $cancelUrl }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
            @endif
        </div>
    </form>
</div>
