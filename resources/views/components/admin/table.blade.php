<div class="overflow-hidden rounded-xl border border-slate-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            @isset($head)
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    {{ $head }}
                </thead>
            @endisset
            <tbody class="divide-y divide-slate-100 bg-white text-sm text-slate-600">
                {{ $body ?? $slot }}
            </tbody>
        </table>
    </div>
</div>

