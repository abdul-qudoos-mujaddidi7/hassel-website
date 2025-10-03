<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin Dashboard') — Mount Agro</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        />
        @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    </head>
    <body class="min-h-full bg-slate-100 font-sans text-slate-900">
        <div class="min-h-full flex">
            @include('admin.partials.sidebar')

            <div class="flex-1 flex flex-col">
                @include('admin.partials.header')

                <main class="flex-1 p-6">
                    @if (session('status'))
                        <x-admin.alert type="success">
                            {{ session('status') }}
                        </x-admin.alert>
                    @endif

                    @if ($errors->any())
                        <x-admin.alert type="error">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-admin.alert>
                    @endif

                    @yield('content')
                </main>

                @include('admin.partials.footer')
            </div>
        </div>
    </body>
</html>


