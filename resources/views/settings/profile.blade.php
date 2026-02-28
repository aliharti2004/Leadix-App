<x-settings-layout>
    <div class="space-y-8">
        <!-- Profile Information -->
        <section class="glass-card p-8 rounded-2xl">
            <header class="mb-6">
                <h2 class="text-xl font-bold text-white">Profile Information</h2>
                <p class="text-gray-400 text-sm mt-1">Update your account's profile information and email address.</p>
            </header>

            <form method="post" action="{{ route('settings.profile.update') }}" class="space-y-6 max-w-xl">
                @csrf
                @method('put')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-400 mb-2">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="btn-gradient px-6 py-2.5 rounded-xl font-semibold text-white shadow-lg shadow-orange-500/20">
                        Save Changes
                    </button>
                </div>
            </form>
        </section>

        <!-- Update Password -->
        <section class="glass-card p-8 rounded-2xl">
            <header class="mb-6">
                <h2 class="text-xl font-bold text-white">Update Password</h2>
                <p class="text-gray-400 text-sm mt-1">Ensure your account is using a long, random password to stay
                    secure.</p>
            </header>

            <form method="post" action="{{ route('settings.password.update') }}" class="space-y-6 max-w-xl">
                @csrf
                @method('put')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-400 mb-2">Current
                        Password</label>
                    <input type="password" name="current_password" id="current_password" autocomplete="current-password"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all">
                    <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-2">New Password</label>
                    <input type="password" name="password" id="password" autocomplete="new-password"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-400 mb-2">Confirm
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        autocomplete="new-password"
                        class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500/50 focus:border-orange-500 transition-all">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit"
                        class="btn-gradient px-6 py-2.5 rounded-xl font-semibold text-white shadow-lg shadow-orange-500/20">
                        Update Password
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-settings-layout>