{{-- resources/views/layouts/app.blade.php --}}

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'HR Management')</title>

    {{-- Google Fonts - Inter (Modern & Professional) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">



    <style>
        /* Custom Typography Enhancements */
        body {
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Better number rendering for data-heavy tables */
        .tabular-nums {
            font-variant-numeric: tabular-nums;
        }

        /* Smooth transitions for interactive elements */
        .nav-link {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Focus states for accessibility */
        *:focus-visible {
            outline: 2px solid #4f46e5;
            outline-offset: 2px;
        }
    </style>

</head>
<body class="h-full">
<div x-data="{ sidebarOpen: true }" class="flex h-full">
    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'w-64' : 'w-16'" class="bg-indigo-900 text-white transition-all duration-300 flex flex-col">
        <div class="h-16 flex items-center justify-center border-b border-indigo-800">
            <span x-show="sidebarOpen" class="text-xl font-bold">HR<span class="text-indigo-400">Pro</span></span>
            <span x-show="!sidebarOpen" class="text-xl font-bold">H</span>
        </div>

        {{-- Vertical Nav --}}
        <x-nav />

    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Top Header --}}
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="flex items-center space-x-4">
                <button class="relative p-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name ?? 'Admin' }}&background=4F46E5&color=fff" class="w-8 h-8 rounded-full">
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <main class="flex-1 overflow-auto bg-gray-50 p-6">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['Inter', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                },
                colors: {
                    indigo: {
                        50: '#eef2ff',
                        100: '#e0e7ff',
                        200: '#c7d2fe',
                        300: '#a5b4fc',
                        400: '#818cf8',
                        500: '#6366f1',
                        600: '#4f46e5',
                        700: '#4338ca',
                        800: '#3730a3',
                        900: '#312e81',
                        950: '#1e1b4b',
                    }
                }
            }
        }
    }
</script>

<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>

