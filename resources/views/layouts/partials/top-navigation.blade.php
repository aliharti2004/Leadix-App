{{-- Top Navigation Bar --}}
<header class="glass-header h-16 sticky top-0 z-40 flex items-center justify-between px-6">
    {{-- Left Side: Mobile Toggle Only --}}
    <div class="flex items-center gap-4 md:hidden">
        {{-- Mobile Hamburger --}}
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    {{-- Center: Search Bar --}}
    <div class="w-full max-w-md hidden md:block">
        <form action="{{ route('search') }}" method="GET">
            <div class="relative group">
                <span
                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 group-focus-within:text-orange-500 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" name="q" placeholder="Search..."
                    class="w-full bg-white/5 text-white border border-white/10 rounded-full pl-10 pr-4 py-2 focus:ring-2 focus:ring-orange-500 focus:bg-white/10 transition-all text-sm placeholder-gray-500">
            </div>
        </form>
    </div>

    {{-- Right Side: Notifications, Date, Role, User --}}
    <div class="flex items-center gap-3">
        {{-- Notifications Dropdown --}}
        <div class="relative" x-data="{ notificationOpen: false }">
            <button @click="notificationOpen = !notificationOpen"
                class="relative p-2 text-gray-400 hover:text-white transition focus:outline-none">
                <span class="sr-only">Notifications</span>
                {{-- Bell Icon --}}
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>

                {{-- Unread Badge --}}
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span
                        class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-red-500 rounded-full border-2 border-[#1a1a1a] text-[10px] font-bold text-white flex items-center justify-center">
                        {{ auth()->user()->unreadNotifications->count() > 9 ? '9+' : auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>

            {{-- Dropdown Panel --}}
            <div x-show="notificationOpen" @click.away="notificationOpen = false"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                style="display: none;"
                class="absolute right-0 mt-2 w-80 bg-[#1a1a1a] border border-white/10 rounded-xl shadow-2xl overflow-hidden z-50">

                {{-- Header --}}
                <div class="px-4 py-3 border-b border-white/10 flex justify-between items-center bg-white/5">
                    <h3 class="text-sm font-bold text-white">Notifications</h3>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <button onclick="markAllRead()" class="text-xs text-orange-500 hover:text-orange-400 font-bold">
                            Mark all read
                        </button>
                    @endif
                </div>

                {{-- List --}}
                <div class="max-h-96 overflow-y-auto">
                    @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                        @php
                            $type = $notification->data['type'] ?? 'info';
                            $borderColors = [
                                'deal_won' => 'border-l-green-500',
                                'payment_received' => 'border-l-emerald-500',
                                'invoice_overdue' => 'border-l-red-500',
                                'invoice_created' => 'border-l-blue-500',
                                'contact_created' => 'border-l-indigo-500',
                            ];
                            $borderClass = $borderColors[$type] ?? 'border-l-gray-500';
                        @endphp
                        
                        <div class="px-4 py-3 border-b border-white/5 border-l-2 {{ $borderClass }} hover:bg-white/5 transition cursor-pointer group"
                            onclick="markRead('{{ $notification->id }}', '{{ isset($notification->data['url']) ? $notification->data['url'] : '#' }}')">
                            <div class="flex items-start gap-3">
                                {{-- Icon --}}
                                <div class="flex-shrink-0 mt-1">
                                    @include('layouts.partials.notification-icon', ['icon' => $notification->data['icon'] ?? '', 'type' => $type])
                                </div>

                                {{-- Content --}}
                                <div>
                                    @php
                                        $textColors = [
                                            'deal_won' => 'text-green-400',
                                            'payment_received' => 'text-emerald-400',
                                            'invoice_overdue' => 'text-red-400',
                                            'invoice_created' => 'text-blue-400',
                                            'contact_created' => 'text-indigo-400',
                                        ];
                                        $messageColor = $textColors[$type] ?? 'text-gray-400';
                                    @endphp
                                    <p class="text-sm font-bold text-white group-hover:text-orange-500 transition">
                                        {{ $notification->data['type'] ?? 'Notification' }}</p>
                                    <p class="text-xs {{ $messageColor }} mt-1 font-medium">
                                        {{ $notification->data['message'] ?? 'You have a new notification.' }}</p>
                                    <p class="text-[10px] text-gray-500 mt-2 font-mono">
                                        {{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <p class="text-gray-500 text-sm">No new notifications</p>
                        </div>
                    @endforelse
                </div>

                {{-- Footer: View All Link --}}
                <div class="px-4 py-3 border-t border-white/10 bg-white/5">
                    <a href="{{ route('notifications.index') }}" 
                        class="block text-center text-sm font-bold text-orange-500 hover:text-orange-400 transition">
                        View All Notifications
                    </a>
                </div>
            </div>
        </div>

        {{-- Date --}}
        <span class="text-gray-600 text-sm font-medium hidden sm:block">{{ now()->format('l, M d, Y') }}</span>

        {{-- Role Badge --}}
        <span
            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/5 border border-white/10 text-orange-400 uppercase tracking-wide">
            {{ Auth::user()->role }}
        </span>

        {{-- User Dropdown --}}
        <div class="relative ml-3">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="flex items-center gap-2 text-sm font-medium text-gray-400 hover:text-white transition focus:outline-none">
                        <div
                            class="h-8 w-8 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold shadow-lg shadow-orange-500/20">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="hidden md:block">{{ Auth::user()->name }}</span>
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-4 py-2 border-b border-white/10">
                        <p class="text-xs text-gray-500 uppercase font-bold">Organization</p>
                        <p class="text-sm font-medium text-white">
                            {{ Auth::user()->organization->name ?? 'No Org' }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>

{{-- Notification JS Functions --}}
<script>
    function markRead(id, url) {
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(() => {
            if (url && url !== '#') window.location.href = url;
            else window.location.reload();
        });
    }

    function markAllRead() {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        }).then(() => {
            window.location.reload();
        });
    }
</script>