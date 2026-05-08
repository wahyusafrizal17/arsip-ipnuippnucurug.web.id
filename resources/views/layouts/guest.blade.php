<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@isset($title){{ $title }} · @endisset{{ config('app.name', 'Arsip Digital') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo-ipnu.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <style>[x-cloak]{display:none!important}</style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 font-sans text-slate-100 antialiased">
    <div class="relative flex min-h-screen flex-col justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-24 top-1/4 h-72 w-72 rounded-full bg-emerald-600/20 blur-3xl"></div>
            <div class="absolute -right-24 bottom-1/4 h-72 w-72 rounded-full bg-yellow-500/15 blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-emerald-950/50 via-slate-950 to-slate-950"></div>
        </div>

        <div class="relative mx-auto w-full max-w-md">
            <div class="mb-8 flex flex-col items-center text-center">
                <div class="flex items-center justify-center gap-2 rounded-2xl bg-white p-3 shadow-xl shadow-black/30 ring-2 ring-yellow-400/60 ring-offset-4 ring-offset-slate-950 sm:gap-3 sm:p-4">
                    <img
                        src="{{ asset('images/logo-ipnu.png') }}"
                        alt="Logo IPNU"
                        width="96"
                        height="96"
                        class="h-20 w-20 object-contain sm:h-24 sm:w-24"
                    />
                    <img
                        src="{{ asset('images/logo-ippnu.png') }}"
                        alt="Logo IPPNU"
                        width="96"
                        height="96"
                        class="h-20 w-20 object-contain sm:h-24 sm:w-24"
                    />
                </div>
                <h1 class="mt-6 text-2xl font-bold tracking-tight text-white">{{ config('app.name') }}</h1>
                <p class="mt-2 text-sm text-slate-400">Masuk untuk mengelola arsip digital PR IPNU IPPNU CURUG</p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/5 p-8 shadow-2xl shadow-black/40 backdrop-blur-xl ring-1 ring-white/10">
                {{ $slot }}
            </div>

            <p class="mt-8 text-center text-xs text-slate-500">
                Ikatan Pelajar Nahdlatul Ulama · Sistem Arsip Digital
            </p>
        </div>
    </div>
</body>
</html>
