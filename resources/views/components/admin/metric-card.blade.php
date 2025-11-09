@props([
    'title',
    'value',
    'description' => null,
    'trend' => 'neutral',
])

@php
$palette = [
    'positive' => 'text-emerald-600 bg-emerald-50 border-emerald-100',
    'neutral' => 'text-slate-600 bg-slate-50 border-slate-100',
    'negative' => 'text-rose-600 bg-rose-50 border-rose-100',
];

$badgeClasses = $palette[$trend] ?? $palette['neutral'];
@endphp

<div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-sm shadow-slate-900/5 flex items-center justify-between">
    <div>
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $title }}</p>
        <p class="mt-2 text-2xl font-semibold text-slate-900">{{ number_format((int) $value) }}</p>
        @if ($description)
            <p class="mt-1 text-xs text-slate-500">{{ $description }}</p>
        @endif
    </div>
    <div class="self-start">
        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClasses }}">
            @if ($trend === 'positive')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 10l7 -7 7 7M12 3v18" />
                </svg>
            @elseif ($trend === 'negative')
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 14l-7 7-7-7M12 21V3" />
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 12h16" />
                </svg>
            @endif
            {{ ucfirst($trend) }}
        </span>
    </div>
</div>















































