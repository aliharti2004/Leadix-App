@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        {{-- Results Summary --}}
        <div class="flex-1 flex justify-start">
            <p class="text-sm text-gray-400">
                Showing
                <span class="font-bold text-white">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-bold text-white">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-bold text-orange-500">{{ $paginator->total() }}</span>
                results
            </p>
        </div>

        <div class="flex-1 flex justify-center">
            <div class="flex items-center gap-2">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span
                        class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-gray-600 cursor-not-allowed font-bold text-sm">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:border-orange-500/50 hover:bg-orange-500/10 text-gray-400 hover:text-orange-500 transition-all font-bold text-sm">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span class="px-4 py-2 text-gray-600 font-bold">{{ $element }}</span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span
                                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold text-sm shadow-lg shadow-orange-500/30">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:border-orange-500/50 hover:bg-orange-500/10 text-gray-400 hover:text-orange-500 transition-all font-bold text-sm">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 hover:border-orange-500/50 hover:bg-orange-500/10 text-gray-400 hover:text-orange-500 transition-all font-bold text-sm">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                @else
                    <span
                        class="px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-gray-600 cursor-not-allowed font-bold text-sm">
                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                @endif
            </div>
        </div>

        <div class="flex-1"></div>
    </nav>
@endif