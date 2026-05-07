<x-guest-layout>
    <x-slot:title>Masuk</x-slot:title>

    <x-auth-session-status class="mb-4 rounded-lg bg-emerald-500/15 px-3 py-2 text-sm text-emerald-200 ring-1 ring-emerald-500/30" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" value="Email" class="text-slate-300" />
            <x-text-input
                id="email"
                class="mt-2 block w-full border-white/10 bg-white/5 text-white placeholder:text-slate-500 focus:border-emerald-400 focus:ring-emerald-400"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Kata sandi" class="text-slate-300" />
            <x-text-input
                id="password"
                class="mt-2 block w-full border-white/10 bg-white/5 text-white placeholder:text-slate-500 focus:border-emerald-400 focus:ring-emerald-400"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2">
                <input id="remember_me" type="checkbox" class="rounded border-white/20 bg-white/10 text-emerald-600 shadow-sm focus:ring-emerald-400 focus:ring-offset-0 dark:text-emerald-500" name="remember">
                <span class="text-sm text-slate-300">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-yellow-300 hover:text-yellow-200" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="flex w-full justify-center rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-800 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-950/40 ring-1 ring-yellow-400/30 transition hover:from-emerald-500 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 focus:ring-offset-slate-950">
                Masuk
            </button>
        </div>
    </form>
</x-guest-layout>
