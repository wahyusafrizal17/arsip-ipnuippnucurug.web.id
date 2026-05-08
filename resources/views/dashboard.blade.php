<x-app-layout title="Dashboard">
    <div class="mx-auto max-w-7xl space-y-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Ringkasan</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Statistik arsip sesuai peran Anda: <span class="font-medium text-slate-800 dark:text-slate-200">{{ auth()->user()->role->label() }}</span>.</p>
        </div>

        @if($user->isAdmin())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('incoming-letters.index', ['organization' => 'ipnu']) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-indigo-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-indigo-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat masuk IPNU</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($incomingIpnu) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-indigo-600 opacity-0 transition group-hover:opacity-100 dark:text-indigo-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500/15 to-indigo-600/5 text-indigo-600 shadow-inner dark:from-indigo-400/20 dark:to-indigo-500/5 dark:text-indigo-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg>
                        </span>
                    </div>
                </a>
                <a href="{{ route('incoming-letters.index', ['organization' => 'ippnu']) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-indigo-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-indigo-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat masuk IPPNU</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($incomingIppnu) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-indigo-600 opacity-0 transition group-hover:opacity-100 dark:text-indigo-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500/15 to-indigo-600/5 text-indigo-600 shadow-inner dark:from-indigo-400/20 dark:to-indigo-500/5 dark:text-indigo-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg>
                        </span>
                    </div>
                </a>
                <a href="{{ route('incoming-letters.index', ['organization' => 'ipnu_ippnu']) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-indigo-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-indigo-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat masuk IPNU IPPNU</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($incomingIpnuIppnu) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-indigo-600 opacity-0 transition group-hover:opacity-100 dark:text-indigo-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500/15 to-indigo-600/5 text-indigo-600 shadow-inner dark:from-indigo-400/20 dark:to-indigo-500/5 dark:text-indigo-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg>
                        </span>
                    </div>
                </a>
                <a href="{{ route('outgoing-letters.index', ['organization' => 'ipnu']) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-violet-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-violet-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat keluar IPNU</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($outgoingIpnu) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-violet-600 opacity-0 transition group-hover:opacity-100 dark:text-violet-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500/15 to-violet-600/5 text-violet-600 shadow-inner dark:from-violet-400/20 dark:to-violet-500/5 dark:text-violet-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                        </span>
                    </div>
                </a>
                <a href="{{ route('outgoing-letters.index', ['organization' => 'ippnu']) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-violet-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-violet-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat keluar IPPNU</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($outgoingIppnu) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-violet-600 opacity-0 transition group-hover:opacity-100 dark:text-violet-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500/15 to-violet-600/5 text-violet-600 shadow-inner dark:from-violet-400/20 dark:to-violet-500/5 dark:text-violet-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                        </span>
                    </div>
                </a>
                <a href="{{ route('outgoing-letters.index', ['organization' => 'ipnu_ippnu']) }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-violet-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-violet-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat keluar IPNU IPPNU</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($outgoingIpnuIppnu) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-violet-600 opacity-0 transition group-hover:opacity-100 dark:text-violet-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500/15 to-violet-600/5 text-violet-600 shadow-inner dark:from-violet-400/20 dark:to-violet-500/5 dark:text-violet-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                        </span>
                    </div>
                </a>
                <a href="{{ route('inventories.index') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-emerald-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-emerald-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Inventaris</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($inventoryCount) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-emerald-600 opacity-0 transition group-hover:opacity-100 dark:text-emerald-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500/15 to-emerald-600/5 text-emerald-600 shadow-inner dark:from-emerald-400/20 dark:to-emerald-500/5 dark:text-emerald-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                        </span>
                    </div>
                </a>
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('incoming-letters.index') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-indigo-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-indigo-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat masuk</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($incomingCount) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-indigo-600 opacity-0 transition group-hover:opacity-100 dark:text-indigo-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500/15 to-indigo-600/5 text-indigo-600 shadow-inner dark:from-indigo-400/20 dark:to-indigo-500/5 dark:text-indigo-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg>
                        </span>
                    </div>
                </a>
                <a href="{{ route('outgoing-letters.index') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-violet-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-violet-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat keluar</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($outgoingCount) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-violet-600 opacity-0 transition group-hover:opacity-100 dark:text-violet-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500/15 to-violet-600/5 text-violet-600 shadow-inner dark:from-violet-400/20 dark:to-violet-500/5 dark:text-violet-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" /></svg>
                        </span>
                    </div>
                </a>
                <a href="{{ route('inventories.index') }}" class="group relative overflow-hidden rounded-2xl border border-slate-200/90 bg-white p-5 shadow-sm ring-1 ring-slate-950/[0.04] transition hover:-translate-y-0.5 hover:border-emerald-200/90 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:ring-white/[0.06] dark:hover:border-emerald-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Inventaris</p>
                            <p class="mt-2 text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-white">{{ number_format($inventoryCount) }}</p>
                            <p class="mt-3 text-xs font-semibold uppercase tracking-wide text-emerald-600 opacity-0 transition group-hover:opacity-100 dark:text-emerald-400">Lihat daftar →</p>
                        </div>
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500/15 to-emerald-600/5 text-emerald-600 shadow-inner dark:from-emerald-400/20 dark:to-emerald-500/5 dark:text-emerald-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                        </span>
                    </div>
                </a>
            </div>
        @endif

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Arsip surat (6 bulan)</h2>
                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Perbandingan surat masuk vs keluar per bulan{{ $user->isAdmin() ? ' (gabungan IPNU &amp; IPPNU)' : ' (organisasi Anda)' }}.</p>
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
