<div class="w-52 bg-black/90 md:bg-black/40 backdrop-blur-md flex flex-col border-r border-white/5 fixed inset-y-0 left-0 z-40 transform transition-transform duration-300 ease-in-out md:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <!-- Logo -->
    <div class="px-5 py-6 border-b border-white/5 flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="block transition-transform duration-300 hover:scale-105">
            <img src="/images/leadix-logo-new.png" alt="LeadiX" class="h-24 w-auto logo-float">
        </a>
        <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group"
            @if(request()->routeIs('dashboard'))
            style="background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%) !important;" @endif>
            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
            </svg>
            <span class="{{request()->routeIs('dashboard') ? 'font-bold' : 'font-semibold' }}">Dashboard</span>
        </a>

        @if(!auth()->user()->hasRole('finance'))
            {{-- Sales Pipeline (Admin and Sales Only) --}}
            <a href="{{ route('deals.kanban') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl {{ request()->routeIs('deals.*') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group">
                <svg class="w-5 h-5 {{ request()->routeIs('deals.*') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                </svg>
                <span class="{{ request()->routeIs('deals.*') ? 'font-bold' : 'font-semibold' }}">Sales Pipeline</span>
            </a>
        @endif

        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('finance'))
            {{-- Invoices (Admin and Finance) --}}
            <a href="{{ route('invoices.index') }}"
                class="flex items-center gap-3  px-3 py-3 rounded-xl {{request()->routeIs('invoices.*') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group"
                @if(request()->routeIs('invoices.*'))
                style="background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%) !important;" @endif>
                <svg class="w-5 h-5 {{ request()->routeIs('invoices.*') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h6a2 2 0 002-2V6.414A2 2 0 0016.414 5L14 2.586A2 2 0 0012.586 2H9z" />
                    <path d="M3 8a2 2 0 012-2v10h8a2 2 0 01-2 2H5a2 2 0 01-2-2V8z" />
                </svg>
                <span class="{{ request()->routeIs('invoices.*') ? 'font-bold' : 'font-semibold' }}">Invoices</span>
            </a>

            {{-- Cashflow (Admin and Finance) --}}
            <a href="{{ route('cashflow.index') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl {{ request()->routeIs('cashflow.*') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group"
                @if(request()->routeIs('cashflow.*'))
                style="background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%) !important;" @endif>
                <svg class="w-5 h-5 {{ request()->routeIs('cashflow.*') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                        clip-rule="evenodd" />
                </svg>
                <span class="{{ request()->routeIs('cashflow.*') ? 'font-bold' : 'font-semibold' }}">Cashflow</span>
            </a>
        @endif

        @if(!auth()->user()->hasRole('finance'))
            {{-- Leads (Admin and Sales Only) --}}
            <a href="{{ route('leads.index') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl {{ request()->routeIs('leads.*') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group"
                @if(request()->routeIs('leads.*'))
                style="background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%) !important;" @endif>
                <svg class="w-5 h-5 {{ request()->routeIs('leads.*') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                </svg>
                <span class="{{ request()->routeIs('leads.*') ? 'font-bold' : 'font-semibold' }}">Leads</span>
            </a>
        @endif

        {{-- Settings --}}
        <a href="{{ route('settings.profile') }}"
            class="flex items-center gap-3 px-3 py-3 rounded-xl {{ request()->routeIs('settings.*') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group"
            @if(request()->routeIs('settings.*'))
            style="background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%) !important;" @endif>
            <svg class="w-5 h-5 {{ request()->routeIs('settings.*') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                    clip-rule="evenodd" />
            </svg>
            <span class="{{ request()->routeIs('settings.*') ? 'font-bold' : 'font-semibold' }}">Settings</span>
        </a>

        @if(auth()->user()->hasRole('admin'))
            <div class="pt-6 mt-2 border-t border-white/5">
                <p class="text-xs text-gray-600 uppercase tracking-wider px-3 mb-2 font-bold">Workspace</p>

                <!-- Team Settings -->
                <a href="{{ route('settings.team') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl {{ request()->routeIs('settings.team*') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group">
                    <svg class="w-5 h-5 {{ request()->routeIs('settings.team*') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="{{ request()->routeIs('settings.team*') ? 'font-bold' : 'font-semibold' }}">Team
                        Settings</span>
                </a>

                <!-- Contacts -->
                <a href="{{ route('contacts.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl {{ request()->routeIs('contacts.*') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group">
                    <svg class="w-5 h-5 {{ request()->routeIs('contacts.*') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                    <span class="{{ request()->routeIs('contacts.*') ? 'font-bold' : 'font-semibold' }}">Contacts</span>
                </a>

                <!-- Reports -->
                <a href="{{ route('reports.index') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl {{ request()->routeIs('reports.*') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group"
                    @if(request()->routeIs('reports.*'))
                    style="background: linear-gradient(135deg, #ff7300 0%, #ff9500 100%) !important;" @endif>
                    <svg class="w-5 h-5 {{ request()->routeIs('reports.*') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="{{ request()->routeIs('reports.*') ? 'font-bold' : 'font-semibold' }}">Reports</span>
                </a>

                <!-- Settings -->
                <a href="{{ route('settings.profile') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-xl {{ request()->routeIs('settings.*') && !request()->routeIs('settings.team*') ? 'btn-gradient text-white shadow-lg shadow-orange-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }} transition-all text-sm group">
                    <svg class="w-5 h-5 {{ request()->routeIs('settings.*') && !request()->routeIs('settings.team*') ? 'text-white' : 'text-gray-500 group-hover:text-white' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span
                        class="{{ request()->routeIs('settings.*') && !request()->routeIs('settings.team*') ? 'font-bold' : 'font-semibold' }}">Settings</span>
                </a>
            </div>
        @endif
    </nav>

    <!-- User Profile (Pinned to bottom) -->
    <div class="p-3 border-t border-white/5">
        <div class="flex items-center gap-2.5 px-2 py-2 rounded-xl hover:bg-white/5 cursor-pointer transition">
            <div
                class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-bold bg-white/10 shadow-[0_0_20px_rgba(255,115,0,0.3)]">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white text-xs font-bold truncate">{{ auth()->user()->name }}</p>
                <p class="text-gray-600 text-xs capitalize font-medium">{{ auth()->user()->role ?? 'User' }}</p>
            </div>
        </div>
    </div>
</div>