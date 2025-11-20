@props([
    'title' => null,
    'description' => null,
])

<section {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-900/5']) }}>
    @if ($title || $description)
        <header class="mb-4">
            @if ($title)
                <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
            @endif
            @if ($description)
                <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
            @endif
        </header>
    @endif

    {{ $slot }}
</section>





















































