<header class="bg-white border-b border-slate-200/80">
    <div class="px-6 h-20 flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Welcome back</p>
            <h1 class="text-xl font-semibold text-slate-900">
                {{ auth()->user()->name ?? 'Administrator' }}
            </h1>
        </div>

        <div class="flex items-center gap-5">
            <div class="hidden md:flex items-center gap-2 bg-slate-100 border border-slate-200 rounded-xl px-3 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-3 -3v6m0 -11a8 8 0 1 0 8 8a8 8 0 0 0 -8 -8" />
                </svg>
                <span class="text-xs font-medium text-slate-600 uppercase">{{ now()->format('D, d M Y') }}</span>
            </div>

            <button class="relative h-10 w-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-slate-700 hover:border-slate-300 transition-all">
                <span class="absolute top-1 right-1 inline-flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405 -1.405a2.032 2.032 0 0 1 -.595 -1.44V11a6 6 0 1 0 -12 0v3.155c0 .538 -.214 1.055 -.595 1.44L4 17h5m6 0a3 3 0 1 1 -6 0m6 0h-6" />
                </svg>
            </button>

            <div class="relative">
                <button class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-3 py-2 hover:border-slate-300 transition-all">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 text-white text-lg font-semibold shadow-lg shadow-emerald-500/30">
                        {{ strtoupper(substr(auth()->user()->name ?? 'MA', 0, 1)) }}
                    </span>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? 'Mount Agro Admin' }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->email ?? 'admin@mountagro.af' }}</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 9l6 6 6 -6" />
                    </svg>
                </button>

                <div class="absolute right-0 mt-2 w-64 bg-white border border-slate-200 rounded-xl shadow-lg shadow-slate-900/10 py-2 hidden group-hover:block">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h18v4H3zM4 7v13h16V7" />
                        </svg>
                        Dashboard
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="px-4 py-2">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 text-sm text-rose-600 hover:text-rose-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12H3m6 -6l-6 6 6 6" />
                            </svg>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>




