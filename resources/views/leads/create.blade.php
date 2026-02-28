@extends('layouts.app')

@section('header', 'Create Lead')

@section('content')
    <style>
        .glass-card {
            background: rgba(20, 20, 20, 0.6);
            backdrop-filter: blur(10px);
        }
    </style>

    <div class="max-w-4xl mx-auto">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('leads.index') }}"
                class="text-gray-400 hover:text-white flex items-center gap-2 mb-4 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Leads
            </a>
            <h2 class="text-2xl font-black text-white">Create New Lead</h2>
            <p class="text-gray-400 mt-1">Add a new potential customer to your pipeline</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('leads.store') }}" method="POST" class="glass-card rounded-2xl p-8 border border-white/10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Lead Title --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Lead Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="e.g., Enterprise CRM Solution for Acme Corp">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contact Name --}}
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Contact Name</label>
                    <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="John Doe">
                    @error('contact_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="john@example.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="+1 (555) 123-4567">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Company --}}
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Company</label>
                    <input type="text" name="company" value="{{ old('company') }}"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="Acme Corporation">
                    @error('company')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Job Title --}}
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Job Title</label>
                    <input type="text" name="job_title" value="{{ old('job_title') }}"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        placeholder="CEO">
                    @error('job_title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Source --}}
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Source</label>
                    <select name="source"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        <option value="website" {{ old('source') == 'website' ? 'selected' : '' }}>Website</option>
                        <option value="referral" {{ old('source') == 'referral' ? 'selected' : '' }}>Referral</option>
                        <option value="cold_call" {{ old('source') == 'cold_call' ? 'selected' : '' }}>Cold Call</option>
                        <option value="linkedin" {{ old('source') == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                        <option value="event" {{ old('source') == 'event' ? 'selected' : '' }}>Event</option>
                        <option value="other" {{ old('source') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('source')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Status</label>
                    <select name="status"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        <option value="new" {{ old('status', 'new') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="qualified" {{ old('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                        <option value="nurturing" {{ old('status') == 'nurturing' ? 'selected' : '' }}>Nurturing</option>
                        <option value="disqualified" {{ old('status') == 'disqualified' ? 'selected' : '' }}>Disqualified
                        </option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estimated Value --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Estimated
                        Value</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-bold">$</span>
                        <input type="number" name="estimated_value" value="{{ old('estimated_value', 0) }}" step="0.01"
                            min="0"
                            class="w-full bg-black/30 text-white border border-white/10 rounded-xl pl-8 pr-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                            placeholder="10000">
                    </div>
                    @error('estimated_value')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Notes</label>
                    <textarea name="notes" rows="4"
                        class="w-full bg-black/30 text-white border border-white/10 rounded-xl px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-transparent transition resize-none"
                        placeholder="Add any additional notes or context about this lead...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-white/10">
                <a href="{{ route('leads.index') }}"
                    class="px-6 py-3 bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white rounded-xl font-bold text-sm transition border border-white/10">
                    Cancel
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-xl font-bold text-sm shadow-lg shadow-orange-500/30 transition-all">
                    Create Lead
                </button>
            </div>
        </form>
    </div>
@endsection