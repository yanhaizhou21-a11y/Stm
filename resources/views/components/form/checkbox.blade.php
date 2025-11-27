@props([
    'label',
    'name',
    'checked' => false
])

<div {{ $attributes->merge(['class' => 'flex items-center']) }}>
    <input
        type="checkbox"
        id="{{ $name }}"
        name="{{ $name }}"
        value="1"
        {{ old($name, $checked) ? 'checked' : '' }}
        class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-2 focus:ring-indigo-500 transition"
    >
    @if($label)
    <label for="{{ $name }}" class="ml-2 text-sm font-medium text-slate-700">
        {{ $label }}
    </label>
    @endif
    
    @error($name)
    <p class="text-sm text-red-600 ml-2">{{ $message }}</p>
    @enderror
</div>
