@props([
    'label',
    'name',
    'id' => null,
    'type' => 'text',
    'value' => '',
    'required' => false,
    'placeholder' => ''
])

@php
    $id = $id ?? $name;
@endphp

<div {{ $attributes->merge(['class' => 'space-y-2']) }}>
    @if($label)
    <label for="{{ $id }}" class="block text-sm font-medium text-slate-700">
        {{ $label }}
        @if($required)
        <span class="text-red-500">*</span>
        @endif
    </label>
    @endif
    
    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition text-slate-900 placeholder-slate-400"
    >
    
    @error($name)
    <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
