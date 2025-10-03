@props([
    'icon' => null,
    'active' => false,
])

@php
$classes = $active
    ? 'bg-slate-800/80 text-white shadow-sm shadow-slate-900/40'
    : 'text-slate-300 hover:text-white hover:bg-slate-800/60';

$icons = [
    'heroicon-o-home' => 'M3 9.75L12 3l9 6.75V20.25a1.5 1.5 0 0 1 -1.5 1.5h-4.5V15a1.5 1.5 0 0 0 -1.5 -1.5h-3a1.5 1.5 0 0 0 -1.5 1.5v6.75H4.5A1.5 1.5 0 0 1 3 20.25z',
    'heroicon-o-newspaper' => 'M4.5 5.25h15a1.5 1.5 0 0 1 1.5 1.5v11.25a1.5 1.5 0 0 1 -1.5 1.5H5.625a2.625 2.625 0 0 1 -2.625 -2.625V6.75a1.5 1.5 0 0 1 1.5 -1.5zM6 9h6m-6 3h6M6 15h6M15 9h3M15 12h3M15 15h3',
    'heroicon-o-photo' => 'M3 6.75A2.25 2.25 0 0 1 5.25 4.5h13.5A2.25 2.25 0 0 1 21 6.75v10.5A2.25 2.25 0 0 1 18.75 19.5H5.25A2.25 2.25 0 0 1 3 17.25zm1.5 8.25 4.159 -4.158a1.125 1.125 0 0 1 1.59 0L15 15l2.182 -2.182a1.125 1.125 0 0 1 1.59 0L19.5 16.5M9 9a1.5 1.5 0 1 1 -3 0a1.5 1.5 0 0 1 3 0z',
    'heroicon-o-document-text' => 'M9 12h6m-6 3h3m1.5 -11.25H9A2.25 2.25 0 0 0 6.75 6v12A2.25 2.25 0 0 0 9 20.25h6A2.25 2.25 0 0 0 17.25 18V9.75z M15.75 9.75H17.25L15.75 8.25z',
    'heroicon-o-academic-cap' => 'M12 3L1.5 9l10.5 6 10.5 -6M6 12v5.25a.75.75 0 0 0 .45.685l5.1 2.043a.75.75 0 0 0 .6 0l5.1 -2.043a.75.75 0 0 0 .45 -.685V12',
    'heroicon-o-cube' => 'M21 7.125v9.75a.75.75 0 0 1 -.375.65l-8.25 4.5a.75.75 0 0 1 -.75 0l-8.25 -4.5A.75.75 0 0 1 3 16.875v-9.75a.75.75 0 0 1 .375 -.65l8.25 -4.5a.75.75 0 0 1 .75 0l8.25 4.5A.75.75 0 0 1 21 7.125zM12 12.75 3.375 7.5M12 12.75l8.625 -5.25M12 12.75v9',
    'heroicon-o-globe' => 'M21 12a9 9 0 1 1 -18 0a9 9 0 0 1 18 0zm-9 9c2.485 0 4.5 -4.03 4.5 -9S14.485 3 12 3 7.5 7.03 7.5 12 9.515 21 12 21zm0 0c-4.97 0 -9 -4.03 -9 -9m9 9c4.97 0 9 -4.03 9 -9M3 12c0 -4.97 4.03 -9 9 -9',
    'heroicon-o-inbox' => 'M2.25 12l2.036 -6.11A2.25 2.25 0 0 1 6.445 4.5h11.11a2.25 2.25 0 0 1 2.159 1.39L21.75 12M2.25 12v4.5A2.25 2.25 0 0 0 4.5 18.75h15A2.25 2.25 0 0 0 21.75 16.5V12m-19.5 0h5.508a2.25 2.25 0 0 0 2.121 1.5h4.242a2.25 2.25 0 0 0 2.121 -1.5h5.508',
    'heroicon-o-user-group' => 'M18 20.25v-2.25A3.75 3.75 0 0 0 14.25 14.25h-4.5A3.75 3.75 0 0 0 6 18v2.25m12 -8.25a3 3 0 1 0 -3 -3a3 3 0 0 0 3 3zm-10.5 0a3 3 0 1 0 -3 -3a3 3 0 0 0 3 3z',
    'heroicon-o-chart-pie' => 'M12 3.75a.75.75 0 0 1 .75.75v7.5h7.5a.75.75 0 0 1 .75.75 9 9 0 1 1 -9 -9zM12.75 4.606a7.5 7.5 0 1 1 -8.144 8.144h7.394a.75.75 0 0 0 .75 -.75z',
];
@endphp

<a {{ $attributes->merge(['class' => "group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-150 {$classes}"]) }}>
    @if ($icon && isset($icons[$icon]))
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="h-5 w-5 text-slate-400 group-hover:text-white"
        >
            <path d="{{ $icons[$icon] }}" />
        </svg>
    @endif
    <span>{{ $slot }}</span>
</a>

