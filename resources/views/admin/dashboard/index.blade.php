@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-semibold text-slate-900">Dashboard Overview</h2>
            <p class="text-sm text-slate-500">Monitor the health of your platform and manage content effortlessly.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($stats['content'] as $label => $value)
                <x-admin.stat-card
                    :title="str($label)->headline()"
                    :value="$value"
                    variant="emerald"
                />
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-admin.metric-card
                title="Contacts"
                :value="$stats['engagement']['contacts']"
                description="Inbound requests this month"
                trend="positive"
            />
            <x-admin.metric-card
                title="Registrations"
                :value="$stats['engagement']['registrations']"
                description="Program applications submitted"
                trend="neutral"
            />
            <x-admin.metric-card
                title="Beneficiaries"
                :value="$stats['engagement']['beneficiaries']"
                description="Total beneficiaries served"
                trend="positive"
            />
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <x-admin.panel title="Latest News" description="Recent stories and updates">
                <x-admin.table>
                    <x-slot name="head">
                        <tr>
                            <th class="text-left">Title</th>
                            <th class="text-left">Status</th>
                            <th class="text-left">Published</th>
                        </tr>
                    </x-slot>
                    <x-slot name="body">
                        @forelse ($latestNews as $news)
                            <tr>
                                <td class="font-medium text-slate-900">{{ $news->title }}</td>
                                <td>
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                                        {{ ucfirst($news->status) }}
                                    </span>
                                </td>
                                <td class="text-sm text-slate-500">{{ $news->published_at?->format('M d, Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-sm text-slate-500 py-4">No news yet.</td>
                            </tr>
                        @endforelse
                    </x-slot>
                </x-admin.table>
            </x-admin.panel>

            <x-admin.panel title="Recent Contacts" description="Latest inquiries">
                <ul class="space-y-4">
                    @forelse ($latestContacts as $contact)
                        <li class="flex items-start justify-between">
                            <div>
                                <p class="font-medium text-slate-900">{{ $contact->name }}</p>
                                <p class="text-xs text-slate-500">{{ $contact->email }}</p>
                            </div>
                            <span class="text-xs text-slate-400">{{ $contact->created_at->diffForHumans() }}</span>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">No contact messages yet.</li>
                    @endforelse
                </ul>
            </x-admin.panel>
        </div>

        <x-admin.panel title="Latest Program Registrations" description="Track new sign-ups">
            <x-admin.table>
                <x-slot name="head">
                    <tr>
                        <th class="text-left">Applicant</th>
                        <th class="text-left">Program</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Applied</th>
                    </tr>
                </x-slot>
                <x-slot name="body">
                    @forelse ($latestRegistrations as $registration)
                        <tr>
                            <td class="font-medium text-slate-900">{{ $registration->name }}</td>
                            <td class="text-sm text-slate-500">{{ $registration->program?->title ?? '—' }}</td>
                            <td>
                                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                                    {{ ucfirst($registration->status) }}
                                </span>
                            </td>
                            <td class="text-sm text-slate-500">{{ $registration->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-sm text-slate-500 py-4">No registrations available.</td>
                        </tr>
                    @endforelse
                </x-slot>
            </x-admin.table>
        </x-admin.panel>
    </div>
@endsection




