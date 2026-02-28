@extends('layouts.app')

@section('header', 'Leads')

@section('content')
    <style>
        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
        }
    </style>

    <div>
        {{-- Header with Create Button --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-black text-white mb-2">Leads</h2>
                <p class="text-gray-400">Manage and track potential customers</p>
            </div>
            <a href="{{ route('leads.create') }}"
                class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl font-bold text-sm flex items-center gap-2 shadow-lg shadow-orange-500/30 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create Lead
            </a>
        </div>

        {{-- Filter Bar --}}
        <div class="glass-card rounded-2xl p-5 border border-white/10 mb-6">
            <form method="GET" action="{{ route('leads.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search leads..."
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm placeholder-gray-500">
                </div>

                {{-- Status Filter --}}
                <div>
                    <select name="status" onchange="this.form.submit()"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                        <option value="">All Status</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="qualified" {{ request('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                        <option value="nurturing" {{ request('status') == 'nurturing' ? 'selected' : '' }}>Nurturing</option>
                        <option value="disqualified" {{ request('status') == 'disqualified' ? 'selected' : '' }}>Disqualified
                        </option>
                        <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                    </select>
                </div>

                {{-- Source Filter --}}
                <div>
                    <select name="source" onchange="this.form.submit()"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition text-sm">
                        <option value="">All Sources</option>
                        <option value="website" {{ request('source') == 'website' ? 'selected' : '' }}>Website</option>
                        <option value="referral" {{ request('source') == 'referral' ? 'selected' : '' }}>Referral</option>
                        <option value="cold_call" {{ request('source') == 'cold_call' ? 'selected' : '' }}>Cold Call</option>
                        <option value="linkedin" {{ request('source') == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                        <option value="event" {{ request('source') == 'event' ? 'selected' : '' }}>Event</option>
                        <option value="other" {{ request('source') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2.5 rounded-xl font-bold text-sm transition">
                        Filter
                    </button>
                    <a href="{{ route('leads.index') }}"
                        class="flex-1 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white px-4 py-2.5 rounded-xl font-bold text-sm transition border border-white/10 text-center">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        {{-- Leads Table --}}
        <div class="glass-card rounded-2xl border border-white/10 overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Company
                        </th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Source</th>
                        <th class="text-left px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Value</th>
                        <th class="text-right px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-white/5 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-orange-500/20 flex items-center justify-center text-orange-500 font-bold">
                                        {{ strtoupper(substr($lead->contact_name ?? $lead->title, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-white font-bold text-sm">{{ $lead->contact_name ?? $lead->title }}</p>
                                        <p class="text-gray-500 text-xs">{{ $lead->title }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-white text-sm">{{ $lead->company ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-400 text-sm">{{ $lead->email ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                        @if($lead->status == 'new') bg-blue-500/20 text-blue-400
                                        @elseif($lead->status == 'contacted') bg-purple-500/20 text-purple-400
                                        @elseif($lead->status == 'qualified') bg-green-500/20 text-green-400
                                        @elseif($lead->status == 'converted') bg-emerald-500/20 text-emerald-400
                                        @elseif($lead->status == 'disqualified') bg-red-500/20 text-red-400
                                        @else bg-gray-500/20 text-gray-400
                                        @endif">
                                    {{ ucfirst($lead->status ?? 'new') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400 text-sm capitalize">
                                {{ str_replace('_', ' ', $lead->source ?? '-') }}</td>
                            <td class="px-6 py-4 text-white font-bold text-sm">
                                ${{ number_format($lead->estimated_value ?? 0, 0) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if($lead->status != 'converted')
                                        <form action="{{ route('leads.convert', $lead) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" title="Convert to Deal"
                                                class="p-2 bg-green-500/10 hover:bg-green-500/20 rounded-lg transition text-green-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2  2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('leads.edit', $lead) }}" title="Edit"
                                        class="p-2 bg-orange-500/10 hover:bg-orange-500/20 rounded-lg transition text-orange-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('leads.destroy', $lead) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Are you sure you want to delete this lead?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete"
                                            class="p-2 bg-red-500/10 hover:bg-red-500/20 rounded-lg transition text-red-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-gray-500 text-sm font-medium">No leads found</p>
                                <a href="{{ route('leads.create') }}"
                                    class="text-orange-500 hover:text-orange-400 text-sm font-bold mt-2 inline-block">
                                    Create your first lead →
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($leads->hasPages())
                <div class="px-6 py-4 border-t border-white/10">
                    {{ $leads->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection