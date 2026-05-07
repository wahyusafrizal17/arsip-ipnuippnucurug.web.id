<x-app-layout title="Dashboard">
    <div class="mx-auto max-w-7xl space-y-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Ringkasan</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Statistik singkat arsip dan inventaris.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <a href="{{ route('incoming-letters.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-indigo-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat Masuk</p>
                        <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($incomingCount) }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg>
                    </span>
                </div>
                <p class="mt-4 text-xs font-medium text-indigo-600 opacity-0 transition group-hover:opacity-100 dark:text-indigo-400">Lihat daftar →</p>
            </a>

            <a href="{{ route('outgoing-letters.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-violet-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-violet-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat Keluar</p>
                        <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($outgoingCount) }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600 dark:bg-violet-950 dark:text-violet-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                    </span>
                </div>
                <p class="mt-4 text-xs font-medium text-violet-600 opacity-0 transition group-hover:opacity-100 dark:text-violet-400">Lihat daftar →</p>
            </a>

            <a href="{{ route('inventories.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-emerald-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-emerald-900">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Inventaris</p>
                        <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($inventoryCount) }}</p>
                    </div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 dark:bg-emerald-950 dark:text-emerald-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                    </span>
                </div>
                <p class="mt-4 text-xs font-medium text-emerald-600 opacity-0 transition group-hover:opacity-100 dark:text-emerald-400">Lihat daftar →</p>
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Arsip surat (6 bulan)</h2>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Perbandingan jumlah surat masuk vs keluar per bulan.</p>
                </div>
                <div class="flex gap-4 text-xs font-medium">
                    <span class="inline-flex items-center gap-2 text-indigo-600 dark:text-indigo-400"><span class="h-2 w-2 rounded-full bg-indigo-500"></span>Masuk</span>
                    <span class="inline-flex items-center gap-2 text-violet-600 dark:text-violet-400"><span class="h-2 w-2 rounded-full bg-violet-500"></span>Keluar</span>
                </div>
            </div>

            <div class="mt-8 flex h-44 items-end gap-2 sm:gap-3">
                @foreach($chartLabels as $i => $label)
                    @php
                        $inH = round(($incomingTrend[$i] / $chartMax) * 100);
                        $outH = round(($outgoingTrend[$i] / $chartMax) * 100);
                        $inH = max($incomingTrend[$i] > 0 ? 12 : 0, $inH);
                        $outH = max($outgoingTrend[$i] > 0 ? 12 : 0, $outH);
                    @endphp
                    <div class="flex min-w-0 flex-1 flex-col items-center gap-2">
                        <div class="flex h-36 w-full items-end justify-center gap-1">
                            <div
                                class="w-1/2 max-w-[14px] rounded-t-md bg-indigo-500 dark:bg-indigo-400"
                                style="height: {{ $inH }}%"
                                title="Masuk: {{ $incomingTrend[$i] }}"
                            ></div>
                            <div
                                class="w-1/2 max-w-[14px] rounded-t-md bg-violet-500 dark:bg-violet-400"
                                style="height: {{ $outH }}%"
                                title="Keluar: {{ $outgoingTrend[$i] }}"
                            ></div>
                        </div>
                        <span class="truncate text-[10px] font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400 sm:text-xs">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
