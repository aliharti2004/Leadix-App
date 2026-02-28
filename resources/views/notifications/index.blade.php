<x-app-layout>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-black text-white">Notifications</h1>
                <p class="text-gray-400 text-sm mt-1">Stay updated on your deals, invoices, and payments</p>
            </div>
            @if($notifications->count() > 0)
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-orange-500 hover:text-orange-400 text-sm font-bold transition">
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->count() > 0)
            <div class="space-y-3">
                @foreach($notifications as $notification)
                    @php
                        $data = $notification->data;
                        $isUnread = is_null($notification->read_at);

                        // Map notification type to semantic colors
                        $type = $data['type'] ?? 'info';
                        $colors = [
                            'deal_won' => ['bg' => 'bg-green-500/10', 'border' => 'border-l-green-500', 'icon-bg' => 'bg-green-500/20', 'icon-text' => 'text-green-500', 'hover' => 'hover:bg-green-500/5'],
                            'payment_received' => ['bg' => 'bg-emerald-500/10', 'border' => 'border-l-emerald-500', 'icon-bg' => 'bg-emerald-500/20', 'icon-text' => 'text-emerald-500', 'hover' => 'hover:bg-emerald-500/5'],
                            'invoice_overdue' => ['bg' => 'bg-red-500/10', 'border' => 'border-l-red-500', 'icon-bg' => 'bg-red-500/20', 'icon-text' => 'text-red-500', 'hover' => 'hover:bg-red-500/5', 'pulse' => 'animate-pulse'],
                            'invoice_created' => ['bg' => 'bg-blue-500/10', 'border' => 'border-l-blue-500', 'icon-bg' => 'bg-blue-500/20', 'icon-text' => 'text-blue-500', 'hover' => 'hover:bg-blue-500/5'],
                            'contact_created' => ['bg' => 'bg-indigo-500/10', 'border' => 'border-l-indigo-500', 'icon-bg' => 'bg-indigo-500/20', 'icon-text' => 'text-indigo-500', 'hover' => 'hover:bg-indigo-500/5'],
                        ];

                        // Fallback based on icon type
                        if (!isset($colors[$type])) {
                            $iconType = $data['icon'] ?? 'info';
                            if ($iconType === 'success') {
                                $colors[$type] = $colors['deal_won'];
                            } elseif ($iconType === 'warning' || $iconType === 'error') {
                                $colors[$type] = $colors['invoice_overdue'];
                            } else {
                                $colors[$type] = $colors['invoice_created'];
                            }
                        }

                        $colorSet = $colors[$type];
                    @endphp

                    <div
                        class="glass-card rounded-2xl p-4 border-l-4 {{ $colorSet['border'] }} {{ $isUnread ? $colorSet['bg'] : 'border-white/5' }} border-r border-t border-b border-white/5 transition-all {{ $colorSet['hover'] ?? '' }} {{ $colorSet['pulse'] ?? '' }}">
                        <div class="flex items-start gap-4">
                            {{-- Icon --}}
                            <div
                                class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 {{ $colorSet['icon-bg'] }} {{ $colorSet['icon-text'] }}">
                                @if(in_array($type, ['deal_won', 'payment_received']) || ($data['icon'] ?? '') === 'success')
                                    {{-- Success Icon --}}
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @elseif($type === 'invoice_overdue' || ($data['icon'] ?? '') === 'warning' || ($data['icon'] ?? '') === 'error')
                                    {{-- Warning/Error Icon --}}
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @elseif($type === 'invoice_created')
                                    {{-- Invoice/Document Icon --}}
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @elseif($type === 'contact_created')
                                    {{-- User/Contact Icon --}}
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @else
                                    {{-- Info Icon (Default) --}}
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                @php
                                    $textColors = [
                                        'deal_won' => 'text-green-400',
                                        'payment_received' => 'text-emerald-400',
                                        'invoice_overdue' => 'text-red-400',
                                        'invoice_created' => 'text-blue-400',
                                        'contact_created' => 'text-indigo-400',
                                    ];
                                    $textColor = $textColors[$type] ?? 'text-white';
                                @endphp
                                <p class="{{ $textColor }} font-bold text-sm mb-1">{{ $data['message'] }}</p>
                                <p class="text-gray-500 text-xs">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2">
                                @if(isset($data['url']))
                                    <a href="{{ $data['url'] }}" class="text-orange-500 hover:text-orange-400 text-sm font-bold">
                                        View
                                    </a>
                                @endif

                                @if($isUnread)
                                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-white text-xs">
                                            Mark read
                                        </button>
                                    </form>
                                @endif

                                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-600 hover:text-red-500 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="glass-card rounded-2xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <h3 class="text-white font-bold text-lg mb-2">No notifications</h3>
                <p class="text-gray-500">You're all caught up! We'll notify you when something important happens.</p>
            </div>
        @endif
    </div>
</x-app-layout>