<x-app-layout>
    <div x-data="contactManager()" class="p-6">
        <header class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-black text-white">Contacts</h1>
                <p class="text-gray-400 font-medium">Manage your professional network and relationships.</p>
            </div>
            <button @click="openAddModal()"
                class="btn-gradient text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 shadow-lg shadow-orange-500/20 hover:scale-105 transition transform">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Contact
            </button>
        </header>

        <!-- Contacts List -->
        <div class="glass-card p-6 rounded-2xl relative overflow-hidden">
            @if($contacts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-gray-500 text-xs uppercase border-b border-white/5">
                                <th class="pb-3 pl-2 font-bold">Contact</th>
                                <th class="pb-3 font-bold">Job Title</th>
                                <th class="pb-3 font-bold">Phone</th>
                                <th class="pb-3 text-right pr-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($contacts as $contact)
                                <tr class="group hover:bg-white/5 transition-colors">
                                    <td class="py-4 pl-2">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center text-sm font-bold text-white border border-white/10">
                                                {{ substr($contact->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-white font-bold text-sm">{{ $contact->name }}</p>
                                                <p class="text-gray-500 text-xs">{{ $contact->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="text-sm text-gray-300 font-medium">{{ $contact->job_title ?? '-' }}</div>
                                        @if($contact->linkedin_url)
                                            <a href="{{ $contact->linkedin_url }}" target="_blank"
                                                class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1 mt-0.5">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                                </svg>
                                                LinkedIn
                                            </a>
                                        @endif
                                    </td>
                                    <td class="py-4 text-gray-400 text-sm">
                                        {{ $contact->phone ?? '-' }}
                                    </td>
                                    <td class="py-4 text-right pr-2">
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" @click="editContact({{ $contact }})"
                                                class="p-2 rounded-lg text-gray-500 hover:text-white hover:bg-white/10 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <button type="button" @click="openDeleteModal({{ $contact->id }})"
                                                class="p-2 rounded-lg text-gray-500 hover:text-red-500 hover:bg-red-500/10 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $contacts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">No contacts yet</h3>
                    <p class="text-gray-400 max-w-sm mx-auto mb-6">Start building your network by adding your first contact.
                    </p>
                    <button @click="openAddModal()"
                        class="btn-gradient text-white px-6 py-2 rounded-lg font-bold shadow-lg shadow-orange-500/20 hover:scale-105 transition transform">
                        Add Contact
                    </button>
                </div>
            @endif
        </div>

        <!-- Add/Edit Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <div @click="modalOpen = false" x-show="modalOpen" x-transition.opacity
                class="absolute inset-0 bg-black/80 backdrop-blur-sm"></div>

            <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                class="relative glass-card w-full max-w-lg p-6 rounded-2xl border border-white/10 shadow-2xl">

                <h3 class="text-xl font-bold text-white mb-1" x-text="isEditing ? 'Edit Contact' : 'Add Contact'"></h3>
                <p class="text-gray-400 text-sm mb-6">Enter the contact's details below.</p>

                <form :action="isEditing ? '/contacts/' + form.id : '{{ route('contacts.store') }}'" method="POST">
                    @csrf
                    <template x-if="isEditing">
                        @method('PUT')
                    </template>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full Name</label>
                            <input type="text" name="name" x-model="form.name" required placeholder="John Doe"
                                class="w-full bg-black/50 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email Address</label>
                            <input type="email" name="email" x-model="form.email" placeholder="john@example.com"
                                class="w-full bg-black/50 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Phone</label>
                                <input type="text" name="phone" x-model="form.phone" placeholder="+1 (555) 000-0000"
                                    class="w-full bg-black/50 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Job Title</label>
                                <input type="text" name="job_title" x-model="form.job_title"
                                    placeholder="CEO, Manager..."
                                    class="w-full bg-black/50 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">LinkedIn URL</label>
                            <input type="url" name="linkedin_url" x-model="form.linkedin_url"
                                placeholder="https://linkedin.com/in/..."
                                class="w-full bg-black/50 border border-white/10 rounded-lg px-4 py-2.5 text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="modalOpen = false"
                            class="text-gray-400 hover:text-white font-bold text-sm px-4 py-2 hover:bg-white/5 rounded-lg transition">Cancel</button>
                        <button type="submit"
                            class="btn-gradient text-white font-bold text-sm px-6 py-2 rounded-lg shadow-lg shadow-orange-500/20">
                            <span x-text="isEditing ? 'Update Contact' : 'Save Contact'"></span>
                        </button>
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

                <h3 class="text-xl font-bold text-white mb-2">Delete Contact?</h3>
                <p class="text-gray-400 text-sm mb-6">Are you sure you want to delete this contact? This action cannot
                    be undone.</p>

                <div class="flex gap-3 justify-center">
                    <button @click="deleteModalOpen = false"
                        class="text-gray-400 hover:text-white font-bold text-sm px-4 py-2 hover:bg-white/5 rounded-lg transition">Cancel</button>

                    <form method="POST" :action="'/contacts/' + selectedId">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-bold text-sm px-6 py-2 rounded-lg shadow-lg shadow-red-500/20 transition">
                            Delete Contact
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script>
        function contactManager() {
            return {
                modalOpen: false,
                deleteModalOpen: false,
                isEditing: false,
                selectedId: null,
                form: {
                    id: null,
                    name: '',
                    email: '',
                    phone: '',
                    job_title: '',
                    linkedin_url: ''
                },

                openAddModal() {
                    this.isEditing = false;
                    this.form = { id: null, name: '', email: '', phone: '', job_title: '', linkedin_url: '' };
                    this.modalOpen = true;
                },

                editContact(contact) {
                    this.isEditing = true;
                    this.form = { ...contact };
                    this.modalOpen = true;
                },

                openDeleteModal(id) {
                    this.selectedId = id;
                    this.deleteModalOpen = true;
                }
            }
        }
    </script>
</x-app-layout>