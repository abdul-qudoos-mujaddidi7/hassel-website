@props([
    'title',
    'value',
    'variant' => 'emerald',
])

@php
$palette = [
    'emerald' => 'from-emerald-500/10 to-emerald-500/0 text-emerald-600 border-emerald-100',
    'sky' => 'from-sky-500/10 to-sky-500/0 text-sky-600 border-sky-100',
    'amber' => 'from-amber-500/10 to-amber-500/0 text-amber-600 border-amber-100',
];

$classes = $palette[$variant] ?? $palette['emerald'];
@endphp

<div {{ $attributes->merge(['class' => "relative overflow-hidden rounded-2xl border bg-white px-5 py-4 shadow-sm shadow-slate-900/5"] ) }}>
    <div class="absolute inset-0 bg-gradient-to-br {{ $classes }}"></div>
    <div class="relative">
        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $title }}</p>
        <p class="mt-2 text-3xl font-semibold text-slate-900">{{ number_format((int) $value) }}</p>
    </div>
</div>




















































