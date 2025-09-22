<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>

<body class="font-sans antialiased min-h-screen flex flex-col bg-base-200 text-base-content">
    <main class="w-full">
        <div class="drawer lg:drawer-open">
            <input id="sidebar" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content w-full h-screen flex flex-col">
                <div class="navbar bg-base-100 shadow-sm gap-2">
                    <div class="flex-none">
                        <label for="sidebar" class="btn btn-square btn-ghost drawer-button lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block h-5 w-5 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </label>
                    </div>
                    <div class="flex-1 flex flex-col gap-2">
                        <h1 class="text-xs font-semibold">
                            {{ config('app.name') }}
                        </h1>
                        <h5 class="text-[10px] font-semibold hidden lg:block">Chiro IT Solution</h5>
                    </div>
                    <div class="flex-none">
                        <button class="btn btn-square btn-ghost">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block h-5 w-5 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="w-full flex-1 px-4 py-3">
                    @yield('content')
                </div>
            </div>
            <div class="drawer-side border-r-2 border-r-slate-200">
                <label for="sidebar" aria-label="close sidebar" class="drawer-overlay"></label>
                <ul class="menu bg-base-200 text-base-content min-h-full w-full md:w-[40vh] lg:w-[30vh] p-4">
                    <!-- Sidebar content here -->
                    <li><a>Sidebar Item 1</a></li>
                    <li><a>Sidebar Item 2</a></li>
                </ul>

                <label for="sidebar" class="btn btn-primary drawer-button lg:hidden">
                    Open drawer
                </label>
            </div>
        </div>
    </main>

    @livewireScripts
    @stack('scripts')
</body>

</html>
