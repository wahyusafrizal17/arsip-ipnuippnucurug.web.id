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
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50/60 font-sans text-slate-900 antialiased">
    <div class="relative flex min-h-screen flex-col justify-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute left-[10%] top-0 h-64 w-64 rounded-full bg-emerald-200/40 blur-3xl"></div>
            <div class="absolute right-[5%] bottom-[15%] h-72 w-72 rounded-full bg-amber-100/50 blur-3xl"></div>
            <div class="absolute left-1/2 top-1/2 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-teal-100/30 blur-3xl"></div>
        </div>

        <div class="relative mx-auto w-full max-w-md">
            <header class="mb-8 flex flex-col items-center text-center">
                <div class="flex items-center justify-center gap-3 rounded-2xl border border-slate-100 bg-white p-4 shadow-lg shadow-slate-200/60 ring-1 ring-slate-100 sm:gap-4 sm:p-5">
                    <img
                        src="{{ asset('images/logo-ipnu.png') }}"
                        alt="Logo IPNU"
                        width="96"
                        height="96"
                        class="h-16 w-16 object-contain sm:h-[72px] sm:w-[72px]"
                    />
                    <img
                        src="{{ asset('images/logo-ippnu.png') }}"
                        alt="Logo IPPNU"
                        width="96"
                        height="96"
                        class="h-16 w-16 object-contain sm:h-[72px] sm:w-[72px]"
                    />
                </div>
                <h1 class="mt-6 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
                    {{ config('app.name') }}
                </h1>
                <p class="mt-2 max-w-sm text-sm leading-relaxed text-slate-500">
                    Masuk untuk mengelola arsip digital PR IPNU IPPNU CURUG
                </p>
            </header>

            <div class="rounded-2xl border border-slate-100/80 bg-white/90 p-8 shadow-xl shadow-slate-200/40 backdrop-blur sm:p-9">
                {{ $slot }}
            </div>

            <p class="mt-8 text-center text-xs leading-relaxed text-slate-400">
                Ikatan Pelajar Nahdlatul Ulama · Sistem Arsip Digital
            </p>
        </div>
    </div>
</body>
</html>
