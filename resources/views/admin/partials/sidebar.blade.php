<aside class="hidden lg:flex lg:w-72 bg-slate-900 text-slate-100 flex-col">
    <div class="px-6 py-6 border-b border-slate-800">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/90 text-white text-lg font-semibold shadow-lg shadow-emerald-500/30">
                MA
            </span>
            <div>
                <p class="text-sm uppercase tracking-wide text-slate-400">Mount Agro</p>
                <p class="text-base font-semibold">Admin Console</p>
            </div>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-6">
        <nav class="px-4 space-y-2">
            <x-admin.nav-link icon="heroicon-o-home" :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                Overview
            </x-admin.nav-link>

            <x-admin.nav-header>Content Management</x-admin.nav-header>
            <x-admin.nav-link icon="heroicon-o-newspaper" href="#">
                News & Articles
            </x-admin.nav-link>
            <x-admin.nav-link icon="heroicon-o-photo" href="#">
                Galleries
            </x-admin.nav-link>
            <x-admin.nav-link icon="heroicon-o-document-text" href="#">
                Publications
            </x-admin.nav-link>

            <x-admin.nav-header>Programs & Services</x-admin.nav-header>
            <x-admin.nav-link icon="heroicon-o-academic-cap" href="#">
                Training Programs
            </x-admin.nav-link>
            <x-admin.nav-link icon="heroicon-o-cube" href="#">
                Agri-Tech Tools
            </x-admin.nav-link>
            <x-admin.nav-link icon="heroicon-o-globe" href="#">
                Market Access
            </x-admin.nav-link>

            <x-admin.nav-header>Engagement</x-admin.nav-header>
            <x-admin.nav-link icon="heroicon-o-inbox" href="#">
                Contact Requests
            </x-admin.nav-link>
            <x-admin.nav-link icon="heroicon-o-user-group" href="#">
                Program Registrations
            </x-admin.nav-link>

            <x-admin.nav-header>Insights</x-admin.nav-header>
            <x-admin.nav-link icon="heroicon-o-chart-pie" :href="route('admin.analytics')" :active="request()->routeIs('admin.analytics')">
                Analytics
            </x-admin.nav-link>
        </nav>
    </div>

    <div class="px-6 py-5 border-t border-slate-800">
        <div class="bg-slate-800/60 rounded-xl p-4">
            <p class="text-sm font-medium text-slate-200">Need assistance?</p>
            <p class="mt-1 text-xs text-slate-400">Our support team is here to help with any administration questions.</p>
            <a href="mailto:support@mountagro.af" class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-emerald-400 hover:text-emerald-300">
                Contact support
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>
</aside>




