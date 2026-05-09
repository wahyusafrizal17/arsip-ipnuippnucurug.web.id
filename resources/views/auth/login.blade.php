<x-guest-layout>
    <x-slot:title>Masuk</x-slot:title>

    <x-auth-session-status class="mb-4 rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-2.5 text-sm text-emerald-900" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" class="text-slate-700" />
            <x-text-input
                id="email"
                class="mt-2 block w-full rounded-xl border-slate-200 bg-white text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:ring-emerald-500"
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
            <x-input-label for="password" value="Kata sandi" class="text-slate-700" />
            <x-text-input
                id="password"
                class="mt-2 block w-full rounded-xl border-slate-200 bg-white text-slate-900 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                <span class="text-sm text-slate-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-emerald-700 transition hover:text-emerald-800" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <div class="pt-1">
            <button
                type="submit"
                class="flex w-full justify-center rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-emerald-600/25 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
            >
                Masuk
            </button>
        </div>
    </form>
</x-guest-layout>
