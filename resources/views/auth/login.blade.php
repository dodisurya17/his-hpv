<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-7 text-center lg:text-left">
        <h2 class="font-display text-2xl font-bold text-[var(--ink)]">Selamat datang kembali</h2>
        <p class="mt-1.5 text-sm text-gray-500">Masuk untuk melanjutkan ke dasbor HIS HPV.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-[var(--ink)]">Email</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 5.5h14a1 1 0 011 1v7a1 1 0 01-1 1H3a1 1 0 01-1-1v-7a1 1 0 011-1z"/>
                        <path d="M2.5 6l7.5 5 7.5-5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-11 pr-3.5 text-sm text-[var(--ink)] placeholder-gray-400 transition focus:border-[var(--blue)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--blue)]/10"
                    placeholder="nama@sekolah.sch.id">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <div class="mb-1.5 flex items-center justify-between">
                <label for="password" class="block text-sm font-medium text-[var(--ink)]">Kata sandi</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-[var(--blue)] hover:text-[var(--navy)]">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <rect x="4" y="8.5" width="12" height="8" rx="1.6"/>
                        <path d="M6.5 8.5V6a3.5 3.5 0 017 0v2.5" stroke-linecap="round"/>
                    </svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-11 pr-11 text-sm text-[var(--ink)] placeholder-gray-400 transition focus:border-[var(--blue)] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[var(--blue)]/10"
                    placeholder="••••••••">
                <button type="button" onclick="hisHpvTogglePassword()" aria-label="Tampilkan kata sandi"
                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600">
                    <svg id="hisHpvEyeIcon" class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M1.5 10S4.5 4.5 10 4.5 18.5 10 18.5 10 15.5 15.5 10 15.5 1.5 10 1.5 10z" stroke-linejoin="round"/>
                        <circle cx="10" cy="10" r="2.3"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <label for="remember_me" class="flex cursor-pointer items-center gap-2.5 select-none">
            <input id="remember_me" type="checkbox" name="remember"
                class="h-4 w-4 rounded border-gray-300 text-[var(--blue)] focus:ring-[var(--blue)]/40">
            <span class="text-sm text-gray-600">Ingat saya di perangkat ini</span>
        </label>

        <button type="submit"
            class="flex w-full items-center justify-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-110 focus:outline-none focus:ring-4 focus:ring-[var(--blue)]/30"
            style="background: linear-gradient(120deg, var(--navy) 0%, var(--blue) 100%);">
            Masuk
        </button>
    </form>

    <script>
        function hisHpvTogglePassword() {
            const input = document.getElementById('password');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
