<x-settings-layout>
    <div class="space-y-8">
        <!-- Organization Details (Read-Only) -->
        <section class="glass-card p-8 rounded-2xl">
            <header class="mb-6">
                <h2 class="text-xl font-bold text-white">Organization Details</h2>
                <p class="text-gray-400 text-sm mt-1">View your organization's information.</p>
            </header>

            <div class="space-y-6 max-w-xl">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Organization Name</label>
                    <input type="text" name="name" id="name" value="{{ $organization->name }}" disabled readonly
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-gray-400 cursor-not-allowed">
                    <p class="text-gray-500 text-xs mt-2">Contact system administrator to modify organization settings.
                    </p>
                </div>
            </div>
        </section>
    </div>
</x-settings-layout>