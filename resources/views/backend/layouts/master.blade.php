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

                    {{ $slot ?? '' }}
                </div>
            </div>
            <div class="drawer-side border-r-2 border-r-slate-200">
                <label for="sidebar" aria-label="close sidebar" class="drawer-overlay"></label>

                <div class="flex flex-col min-h-screen bg-base-200 w-72 lg:w-72 px-2 pt-0 pb-3">
                    <div class="w-full flex items-center justify-between px-4 p-3 pb-3 border-b-1 border-slate-300">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center justify-start gap-x-4 cursor-pointer">
                            <img src="{{ asset('img/logo.png') }}"
                                class="max-h-12 lg:max-h-16 border border-slate-300 rounded-lg"
                                alt="{{ env('APP_NAME', 'Laravel') }}">
                        </a>

                        <label for="sidebar" class="btn btn-square btn-ghost drawer-button lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                class="inline-block h-5 w-5 stroke-current">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </label>
                    </div>

                    <ul class="menu text-base-content w-full gap-1">
                        <li>
                            <a href="{{ route('dashboard') }}" wire:current="menu-active" wire:navigate>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <details {{ request()->is('master-data/*') ? 'open' : '' }}>
                                <summary class="{{ request()->is('master-data/*') ? 'bg-neutral text-white' : '' }}">
                                    Master Data</summary>
                                <ul class="mt-1">
                                    <li>
                                        <a href="{{ route('pengguna') }}" wire:current="menu-active" wire:navigate>
                                            Akun Pengguna
                                        </a>
                                    </li>
                                    <li><a>Submenu 2</a></li>
                                    <li>
                                        <details>
                                            <summary>Parent</summary>
                                            <ul>
                                                <li><a>Submenu 1</a></li>
                                                <li><a>Submenu 2</a></li>
                                            </ul>
                                        </details>
                                    </li>
                                </ul>
                            </details>
                        </li>
                        <li>
                            <a href="{{ route('test') }}" wire:current="menu-active" wire:navigate>
                                Test
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('awok') }}" wire:current="menu-active" wire:navigate>
                                Awok
                            </a>
                        </li>
                    </ul>

                    <div class="border-t border-slate-300 p-3 mt-auto flex flex-col gap-2">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                                alt="avatar" class="w-10 h-10 rounded-full border border-slate-300" />

                            <div class="flex flex-col">
                                <span class="font-semibold text-sm">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-slate-500">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-neutral w-full">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @livewireScripts
    @stack('scripts')
</body>

</html>
