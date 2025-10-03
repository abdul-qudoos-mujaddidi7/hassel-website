@props([
    'data' => [],
    'variant' => 'emerald',
])

@php
$colors = [
    'emerald' => 'bg-gradient-to-r from-emerald-500 to-emerald-400',
    'sky' => 'bg-gradient-to-r from-sky-500 to-sky-400',
    'amber' => 'bg-gradient-to-r from-amber-500 to-amber-400',
];

$barClass = $colors[$variant] ?? $colors['emerald'];
$max = max(array_map('intval', $data->values()->toArray() ?: [1]));
@endphp

<ul class="space-y-3">
    @forelse ($data as $label => $value)
        @php
            $percentage = $max > 0 ? round(($value / $max) * 100) : 0;
        @endphp
        <li>
            <div class="flex justify-between text-xs font-semibold text-slate-500 mb-1">
                <span>{{ ucfirst($label) }}</span>
                <span>{{ $value }}</span>
            </div>
            <div class="h-2.5 w-full rounded-full bg-slate-100">
                <div class="{{ $barClass }} h-full rounded-full transition-all" style="width: {{ $percentage }}%"></div>
            </div>
        </li>
    @empty
        <li class="text-sm text-slate-500">No data available.</li>
    @endforelse
</ul>

