<x-app-layout>
    <div x-data="teamSettings()" class="p-6">
        <header class="mb-8">
            <h1 class="text-3xl font-black text-white">Team Management</h1>
            <p class="text-gray-400 font-medium">Manage your team members and invitations.</p>
        </header>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Team Members List (Left 2 cols) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Active Members -->
                <div class="glass-card p-6 rounded-2xl relative overflow-hidden">
                    <div class="flex items-center justify-between mb-6 gap-4">
                        <div class="flex-1">
                            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Team Members
                            </h2>
                            <p class="text-gray-400 text-sm mt-1">Manage your team members and roles.</p>
                        </div>

                        <!-- Search Box to fill space -->
                        <div class="hidden md:flex relative w-64">
                            <input type="text" placeholder="Search members..."
                                class="w-full bg-white/5 border border-white/10 rounded-lg pl-10 pr-4 py-2 text-sm text-white focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all">
                            <svg class="w-4 h-4 text-gray-500 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <button @click="openInviteModal()"
                            class="btn-gradient text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Invite Member
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-500 text-xs uppercase border-b border-white/5">
                                    <th class="pb-3 pl-2 font-bold">User</th>
                                    <th class="pb-3 font-bold">Role</th>
                                    <th class="pb-3 font-bold">Joined</th>
                                    <th class="pb-3 text-right pr-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($teamMembers as $member)
                                    <tr class="group hover:bg-white/5 transition-colors">
                                        <td class="py-4 pl-2">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center text-xs font-bold text-white">
                                                    {{ substr($member->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-white font-bold text-sm">{{ $member->name }}</p>
                                                    <p class="text-gray-500 text-xs">{{ $member->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4">
                                            <span
                                                class="px-2 py-1 rounded-md text-xs font-bold uppercase
                                                                                        {{ $member->role === 'admin' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/30' : 'bg-blue-500/20 text-blue-400 border border-blue-500/30' }}">
                                                {{ $member->role }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-gray-500 text-sm">
                                            {{ $member->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="py-4 text-right pr-2">
                                            @if(auth()->id() !== $member->id)
                                                <button type="button" @click="openDeleteModal({{ $member->id }})"
                                                    class="p-2 rounded-lg text-gray-500 hover:text-red-500 hover:bg-red-500/10 transition cursor-pointer">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pending Invitations -->
                @if($pendingInvitations->count() > 0)
                    <div class="glass-card p-6 rounded-2xl relative overflow-hidden">
                        <h2 class="text-xl font-bold text-white flex items-center gap-2 mb-6">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z" />
                            </svg>
                            Pending Invitations
                        </h2>

                        <div class="space-y-3">
                            @foreach($pendingInvitations as $invite)
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/5">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-bold text-sm">{{ $invite->email }}</p>
                                            <p class="text-gray-500 text-xs capitalize flex items-center gap-1">
                                                {{ $invite->role }} • Sent {{ $invite->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('invitations.destroy', $invite->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-gray-500 hover:text-red-500 transition text-xs font-bold px-3 py-1.5 hover:bg-white/5 rounded-lg">
                                            Cancel
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Info (Right col) -->
            <div class="space-y-6">
                <!-- Roles Guide -->
                <div class="glass-card p-6 rounded-2xl border border-white/10">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Roles & Permissions
                    </h3>

                    <div class="space-y-4">
                        <div class="p-4 rounded-xl bg-orange-500/10 border border-orange-500/20">
                            <p class="text-orange-400 font-bold text-xs uppercase mb-1">Admin</p>
                            <p class="text-gray-300 text-sm">Full access to all settings, team management, and billing.
                                Can
                                invite and remove members.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-blue-500/10 border border-blue-500/20">
                            <p class="text-blue-400 font-bold text-xs uppercase mb-1">Finance</p>
                            <p class="text-gray-300 text-sm">Can create and manage invoices, view payments and cashflow
                                reports.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-green-500/10 border border-green-500/20">
                            <p class="text-green-400 font-bold text-xs uppercase mb-1">Sales</p>
                            <p class="text-gray-300 text-sm">Can manage leads, deals, and viewing contacts pipeline.</p>
                        </div>

                        <div class="p-4 rounded-xl bg-gray-500/10 border border-gray-500/20">
                            <p class="text-gray-400 font-bold text-xs uppercase mb-1">Viewer</p>
                            <p class="text-gray-300 text-sm">Read-only access to dashboard and reports. Cannot make
                                changes.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Tips -->
                <div
                    class="glass-card p-6 rounded-2xl bg-gradient-to-br from-indigo-500/10 to-purple-500/10 border-indigo-500/20">
                    <h3 class="text-white font-bold mb-2">Did you know?</h3>
                    <p class="text-gray-400 text-sm">
                        You can invite unlimited team members during your trial period. Build your dream team today!
                    </p>
                </div>
            </div>
        </div>

        <!-- Invite Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <div @click="modalOpen = false" x-show="modalOpen" x-transition.opacity
                class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                class="relative glass-card w-full max-w-md p-6 rounded-2xl border border-white/10 shadow-2xl">

                <h3 class="text-xl font-bold text-white mb-1">Invite Team Member</h3>
                <p class="text-gray-400 text-sm mb-6">Send an invitation email to join your workspace.</p>

                <form action="{{ route('invitations.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email
                                Address</label>
                            <input type="email" name="email" required placeholder="colleague@example.com"
                                class="w-full bg-black/50 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Role</label>
                            <select name="role"
                                class="w-full bg-black/50 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                                <option value="sales">Sales (Manage deals)</option>
                                <option value="finance">Finance (Manage invoices)</option>
                                <option value="admin">Admin (Full access)</option>
                                <option value="viewer">Viewer (Read only)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="modalOpen = false"
                            class="text-gray-400 hover:text-white font-bold text-sm px-4 py-2 hover:bg-white/5 rounded-lg transition">Cancel</button>
                        <button type="submit"
                            class="btn-gradient text-white font-bold text-sm px-6 py-2 rounded-lg shadow-lg shadow-orange-500/20">Send
                            Application</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display: none;">
            <div @click="deleteModalOpen = false" x-show="deleteModalOpen" x-transition.opacity
                class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

            <div x-show="deleteModalOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                class="relative glass-card w-full max-w-sm p-6 rounded-2xl border border-white/10 shadow-2xl text-center">

                <div class="w-12 h-12 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-white mb-2">Remove Team Member?</h3>
                <p class="text-gray-400 text-sm mb-6">Are you sure you want to remove this member? They will lose
                    access
                    to the workspace immediately.</p>

                <div class="flex gap-3 justify-center">
                    <button @click="deleteModalOpen = false"
                        class="text-gray-400 hover:text-white font-bold text-sm px-4 py-2 hover:bg-white/5 rounded-lg transition">Cancel</button>

                    <form method="POST" :action="'/settings/team/' + selectedUserId">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-bold text-sm px-6 py-2 rounded-lg shadow-lg shadow-red-500/20 transition">
                            Remove Member
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        function teamSettings() {
            return {
                modalOpen: false,
                deleteModalOpen: false,
                selectedUserId: null,

                openInviteModal() {
                    this.modalOpen = true;
                },
                openDeleteModal(userId) {
                    this.selectedUserId = userId;
                    this.deleteModalOpen = true;
                }
            }
        }
    </script>
</x-app-layout>