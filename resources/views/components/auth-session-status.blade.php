@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl bg-emerald-50 px-4 py-3 text-xs sm:text-sm font-medium text-emerald-700']) }}>
        {{ $status }}
    </div>
@endif