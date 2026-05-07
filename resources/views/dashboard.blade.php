<x-app-layout title="Dashboard">
    <div class="mx-auto max-w-7xl space-y-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Ringkasan</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Statistik arsip sesuai peran Anda: <span class="font-medium text-slate-800 dark:text-slate-200">{{ auth()->user()->role->label() }}</span>.</p>
        </div>

        @if($user->isAdmin())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('incoming-letters.index', ['organization' => 'ipnu']) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-indigo-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat masuk IPNU</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($incomingIpnu) }}</p>
                    <p class="mt-3 text-xs font-medium text-indigo-600 opacity-0 transition group-hover:opacity-100 dark:text-indigo-400">Lihat daftar →</p>
                </a>
                <a href="{{ route('incoming-letters.index', ['organization' => 'ippnu']) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-indigo-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat masuk IPPNU</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($incomingIppnu) }}</p>
                    <p class="mt-3 text-xs font-medium text-indigo-600 opacity-0 transition group-hover:opacity-100 dark:text-indigo-400">Lihat daftar →</p>
                </a>
                <a href="{{ route('outgoing-letters.index', ['organization' => 'ipnu']) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-violet-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-violet-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat keluar IPNU</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($outgoingIpnu) }}</p>
                    <p class="mt-3 text-xs font-medium text-violet-600 opacity-0 transition group-hover:opacity-100 dark:text-violet-400">Lihat daftar →</p>
                </a>
                <a href="{{ route('outgoing-letters.index', ['organization' => 'ippnu']) }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-violet-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-violet-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat keluar IPPNU</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($outgoingIppnu) }}</p>
                    <p class="mt-3 text-xs font-medium text-violet-600 opacity-0 transition group-hover:opacity-100 dark:text-violet-400">Lihat daftar →</p>
                </a>
                <a href="{{ route('joint-letters.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-teal-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-teal-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat bersama</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($jointCount) }}</p>
                    <p class="mt-3 text-xs font-medium text-teal-600 opacity-0 transition group-hover:opacity-100 dark:text-teal-400">Lihat daftar →</p>
                </a>
                <a href="{{ route('inventories.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-emerald-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-emerald-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Inventaris</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($inventoryCount) }}</p>
                    <p class="mt-3 text-xs font-medium text-emerald-600 opacity-0 transition group-hover:opacity-100 dark:text-emerald-400">Lihat daftar →</p>
                </a>
            </div>
        @else
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <a href="{{ route('incoming-letters.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-indigo-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-indigo-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat masuk</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($incomingCount) }}</p>
                    <p class="mt-3 text-xs font-medium text-indigo-600 opacity-0 transition group-hover:opacity-100 dark:text-indigo-400">Lihat daftar →</p>
                </a>
                <a href="{{ route('outgoing-letters.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-violet-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-violet-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat keluar</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($outgoingCount) }}</p>
                    <p class="mt-3 text-xs font-medium text-violet-600 opacity-0 transition group-hover:opacity-100 dark:text-violet-400">Lihat daftar →</p>
                </a>
                <a href="{{ route('joint-letters.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-teal-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-teal-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Surat bersama</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($jointCount) }}</p>
                    <p class="mt-3 text-xs font-medium text-teal-600 opacity-0 transition group-hover:opacity-100 dark:text-teal-400">Lihat daftar →</p>
                </a>
                <a href="{{ route('inventories.index') }}" class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:border-emerald-200 hover:shadow-md dark:border-slate-800 dark:bg-slate-900 dark:hover:border-emerald-900">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Inventaris</p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-slate-900 dark:text-white">{{ number_format($inventoryCount) }}</p>
                    <p class="mt-3 text-xs font-medium text-emerald-600 opacity-0 transition group-hover:opacity-100 dark:text-emerald-400">Lihat daftar →</p>
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
