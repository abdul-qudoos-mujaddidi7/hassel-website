@props(['type' => 'info'])

@php
$colors = [
    'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
    'error' => 'bg-rose-50 text-rose-700 border-rose-200',
    'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
    'info' => 'bg-sky-50 text-sky-700 border-sky-200',
];

$icons = [
    'success' => 'M9 12l2 2l4 -4',
    'error' => 'M18 6l-12 12M6 6l12 12',
    'warning' => 'M12 9v3m0 3h.01M12 3l9 16H3z',
    'info' => 'M12 12v3m0 -6a.9 .9 0 0 1 0 -1.8a.9 .9 0 0 1 0 1.8',
];

$colorClass = $colors[$type] ?? $colors['info'];
$iconPath = $icons[$type] ?? $icons['info'];
@endphp

<div {{ $attributes->merge(['class' => "border rounded-xl px-4 py-3 flex gap-3 items-start {$colorClass}"]) }}>
    <div class="mt-0.5">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="{{ $iconPath }}" />
        </svg>
    </div>
    <div class="flex-1 text-sm font-medium">
        {{ $slot }}
    </div>
</div>

