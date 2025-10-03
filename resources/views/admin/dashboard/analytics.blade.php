@extends('layouts.admin')

@section('title', 'Analytics')

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">Analytics</h2>
            <p class="text-sm text-slate-500">Understand performance across content and programs.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <x-admin.panel title="News by status">
                <x-admin.analytics-bar :data="$newsByStatus" />
            </x-admin.panel>

            <x-admin.panel title="Programs by status">
                <x-admin.analytics-bar variant="sky" :data="$programsByStatus" />
            </x-admin.panel>

            <x-admin.panel title="Registrations by status">
                <x-admin.analytics-bar variant="amber" :data="$registrationsByStatus" />
            </x-admin.panel>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <x-admin.panel title="Highlights" description="Quick insights from the data">
                <ul class="space-y-3 text-sm text-slate-600">
                    @foreach ($newsByStatus as $status => $total)
                        <li class="flex justify-between">
                            <span>{{ ucfirst($status) }} articles</span>
                            <span class="font-semibold text-slate-900">{{ $total }}</span>
                        </li>
                    @endforeach
                </ul>
            </x-admin.panel>

            <x-admin.panel title="Next steps" description="Suggested actions to maintain momentum">
                <ul class="space-y-2 text-sm text-slate-600">
                    <li>• Review pending program registrations and update statuses.</li>
                    <li>• Publish drafted news items to keep content fresh.</li>
                    <li>• Highlight completed environmental projects on the website.</li>
                </ul>
            </x-admin.panel>
        </div>
    </div>
@endsection




