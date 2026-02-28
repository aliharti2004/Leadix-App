@props(['activities'])

<div class="glass-card rounded-2xl p-6 h-full flex flex-col">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-white font-bold text-lg">Recent Activity</h3>
        <div class="p-2 bg-white/5 rounded-lg">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>

    <div class="space-y-6 overflow-y-auto pr-2 custom-scrollbar flex-1">
        @forelse($activities as $activity)
            <div class="relative pl-6 border-l border-white/10 group hover:border-orange-500/50 transition">
                <!-- Timeline Dot -->
                <div
                    class="absolute -left-[5px] top-1 w-2.5 h-2.5 rounded-full bg-slate-700 group-hover:bg-orange-500 transition shadow-[0_0_10px_rgba(0,0,0,0.5)] group-hover:shadow-[0_0_10px_rgba(255,115,0,0.5)]">
                </div>

                <div class="flex flex-col">
                    <p class="text-gray-300 text-sm">
                        <span class="font-bold text-white">{{ $activity->user->name ?? 'System' }}</span>
                        {{ $activity->description }}
                    </p>

                    @if($activity->subject)
                        <div class="mt-1">
                            @if(class_basename($activity->subject_type) === 'Deal')
                                <a href="{{ route('deals.kanban') }}?search={{ $activity->subject->name }}"
                                    class="text-xs font-bold text-orange-400 hover:text-orange-300 transition flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    {{ $activity->subject->name }}
                                </a>
                            @elseif(class_basename($activity->subject_type) === 'Invoice')
                                <a href="#"
                                    class="text-xs font-bold text-blue-400 hover:text-blue-300 transition flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    {{ $activity->subject->invoice_number }}
                                </a>
                            @elseif(class_basename($activity->subject_type) === 'Lead')
                                <span class="text-xs font-bold text-purple-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $activity->subject->company }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <span class="text-xs text-gray-600 mt-1">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
            </div>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-500 text-sm">No recent activity</p>
            </div>
        @endforelse
    </div>
</div>