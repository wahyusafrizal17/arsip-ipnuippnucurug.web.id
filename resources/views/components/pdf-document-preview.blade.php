@props([
    'path',
    'title' => 'Pratinjau PDF',
])

@php
    $src = asset($path);
@endphp

<div {{ $attributes->class('mt-2') }}>
    {{-- Layar lebar: iframe biasanya berjalan baik di desktop. --}}
    <div class="hidden md:block">
        <iframe
            src="{{ $src }}#toolbar=1"
            class="min-h-[420px] w-full rounded-xl border border-slate-200 dark:border-slate-700"
            title="{{ $title }}"
            loading="lazy"
        ></iframe>
    </div>

    {{-- Ponsel / iframe: PDF sering tidak dirender di iframe; buka di tab/aplikasi sistem. --}}
    <div class="md:hidden">
        <a
            href="{{ $src }}"
            target="_blank"
            rel="noopener noreferrer"
            class="flex min-h-[220px] flex-col items-center justify-center gap-3 rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center transition-colors hover:border-slate-300 hover:bg-slate-100 dark:border-slate-600 dark:bg-slate-800/50 dark:hover:border-slate-500 dark:hover:bg-slate-800"
        >
            <svg class="h-12 w-12 shrink-0 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            <span class="text-sm font-semibold text-slate-800 dark:text-slate-100">Buka pratinjau PDF</span>
            <span class="max-w-xs text-xs leading-relaxed text-slate-500 dark:text-slate-400">Di perangkat ini pratinjau di dalam halaman sering tidak didukung. Ketuk untuk membuka berkas di tab atau aplikasi pembaca PDF.</span>
        </a>
    </div>
</div>
