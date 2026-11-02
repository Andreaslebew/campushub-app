@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs sm:text-sm font-semibold text-neutral-900']) }}>
    {{ $value ?? $slot }}
</label>