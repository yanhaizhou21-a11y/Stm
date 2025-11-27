@props([
    'label',
    'name',
    'options' => [],
    'value' => '',
    'required' => false,
    'placeholder' => 'Select an option'
])

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
    <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">
        {{ $label }}
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif
    
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900"
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
            {{ $optionLabel }}
        </option>
        @endforeach
    </select>
    
    @error($name)
    <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
