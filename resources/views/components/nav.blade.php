{{-- resources/views/components/sidebar-nav.blade.php --}}
<nav class="flex-1 py-4 space-y-1">

    {{-- Tableau de bord --}}
    <a href="{{ route('dashboard0') }}" class="flex items-center px-4 py-3 hover:bg-indigo-800 transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-800 border-r-4 border-white' : '' }}">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
        </svg>
        <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Tableau de bord</span>
    </a>

    {{-- Employés avec sous-menu --}}
    <div x-data="{ open: {{ request()->routeIs('employees.*') ? 'true' : 'false' }} }">
        <button @click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-3 hover:bg-indigo-800 transition-colors {{ request()->routeIs('employees.*') ? 'bg-indigo-800 border-r-4 border-white' : '' }}">
            <div class="flex items-center">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Employés</span>
            </div>
            <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open && sidebarOpen" class="bg-indigo-950">
            <a href="{{ route('employees.index') }}" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('employees.index') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></path></svg>
                    Consulter
                </span>
            </a>
            <a href="{{ route('employees.create') }}" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('employees.create') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></path></svg>
                    Créer
                </span>
            </a>
        </div>
    </div>

    {{-- Locaux avec sous-menu --}}
    <div x-data="{ open: {{ request()->routeIs('locaux.*') ? 'true' : 'false' }} }">
        <button @click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-3 hover:bg-indigo-800 transition-colors {{ request()->routeIs('locaux.*') ? 'bg-indigo-800 border-r-4 border-white' : '' }}">
            <div class="flex items-center">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Locaux</span>
            </div>
            <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open && sidebarOpen" class="bg-indigo-950">
            <a href="" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('locaux.index') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
                <span class="flex items-center">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Locaux
                </span>
            </a>
            <a href="" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('locaux.create') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
                <span class="flex items-center">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Villes
                </span>
            </a>
        </div>
    </div>

    {{-- Unités structurelle avec sous-menu --}}
    <div x-data="{ open: {{ request()->routeIs('unites.*') ? 'true' : 'false' }} }">
        <button @click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-3 hover:bg-indigo-800 transition-colors {{ request()->routeIs('unites.*') ? 'bg-indigo-800 border-r-4 border-white' : '' }}">
            <div class="flex items-center">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Unités structurelle</span>
            </div>
            <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open && sidebarOpen" class="bg-indigo-950">
            <a href="{{ route('services.index') }}" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('unites.index') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></path></svg>
                    Services
                </span>
            </a>
            <a href="{{ route('entities.index') }}" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('unites.create') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></path></svg>
                    Entités
                </span>
            </a>
            <a href="{{ route('sectors.index') }}" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('unites.create') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></path></svg>
                    Secteurs
                </span>
            </a>
            <a href="{{ route('sections.index') }}" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('unites.create') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></path></svg>
                    Sections
                </span>
            </a>
        </div>
    </div>

    {{-- Chefs avec sous-menu --}}
    <div x-data="{ open: {{ request()->routeIs('chefs.*') ? 'true' : 'false' }} }">
        <button @click="open = !open" type="button" class="w-full flex items-center justify-between px-4 py-3 hover:bg-indigo-800 transition-colors {{ request()->routeIs('chefs.*') ? 'bg-indigo-800 border-r-4 border-white' : '' }}">
            <div class="flex items-center">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3 whitespace-nowrap">Chefs</span>
            </div>
            <svg x-show="sidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open && sidebarOpen" class="bg-indigo-950">
            <a href="" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('chefs.index') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Consulter
            </span>
            </a>
            <a href="" class="block pl-12 pr-4 py-2 text-sm hover:bg-indigo-800 transition-colors {{ request()->routeIs('chefs.create') ? 'text-white bg-indigo-800' : 'text-indigo-200' }}">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Créer
            </span>
            </a>
        </div>
    </div>
</nav>
