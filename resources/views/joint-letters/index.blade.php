<x-app-layout title="Surat Bersama">
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Surat Bersama</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Arsip surat bersama IPNU–IPPNU, dapat diakses semua peran.</p>
            </div>
            <a href="{{ route('joint-letters.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-teal-600/25 transition hover:bg-teal-700 dark:bg-teal-500 dark:hover:bg-teal-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Tambah
            </a>
        </div>

        <form method="GET" action="{{ route('joint-letters.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="grid gap-4 md:grid-cols-4 md:items-end">
                <div class="md:col-span-2">
                    <label for="q" class="block text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Pencarian</label>
                    <input id="q" name="q" type="search" value="{{ request('q') }}" placeholder="Nomor surat, pengirim, perihal, klasifikasi, indeks (kode atau label seperti A (internal))..." class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 dark:border-slate-700 dark:bg-slate-950 dark:text-white" />
                </div>
                <div>
                    <label for="date_from" class="block text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Dari tanggal</label>
                    <input id="date_from" name="date_from" type="date" value="{{ request('date_from') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm dark:border-slate-700 dark:bg-slate-950 dark:text-white" />
                </div>
                <div>
                    <label for="date_to" class="block text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Sampai tanggal</label>
                    <input id="date_to" name="date_to" type="date" value="{{ request('date_to') }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm dark:border-slate-700 dark:bg-slate-950 dark:text-white" />
                </div>
            </div>
            <input type="hidden" name="sort" value="{{ $sort }}" />
            <input type="hidden" name="direction" value="{{ $direction }}" />
            <div class="mt-4 flex flex-wrap gap-2">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">Terapkan</button>
                <a href="{{ route('joint-letters.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">Reset</a>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                    <thead class="bg-slate-50 dark:bg-slate-950/60">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Klasifikasi</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Indeks</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">
                                @php
                                    $nextDirection = ($sort === 'nomor_surat' && $direction === 'asc') ? 'desc' : 'asc';
                                    $qs = array_merge(request()->except('page'), ['sort' => 'nomor_surat', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('joint-letters.index', $qs) }}" class="inline-flex items-center gap-1 hover:text-teal-600 dark:hover:text-teal-400">
                                    Nomor surat
                                    @if($sort === 'nomor_surat')
                                        <span class="tabular-nums text-[10px]">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">
                                @php
                                    $nextDirection = ($sort === 'tanggal_surat' && $direction === 'asc') ? 'desc' : 'asc';
                                    $qs = array_merge(request()->except('page'), ['sort' => 'tanggal_surat', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('joint-letters.index', $qs) }}" class="inline-flex items-center gap-1 hover:text-teal-600 dark:hover:text-teal-400">
                                    Tanggal surat
                                    @if($sort === 'tanggal_surat')
                                        <span class="tabular-nums text-[10px]">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Pengirim</th>
                            <th scope="col" class="min-w-[200px] px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Perihal</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($letters as $letter)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-900 dark:text-slate-100">{{ config('archive.klasifikasi')[$letter->klasifikasi] ?? $letter->klasifikasi }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300">{{ config('archive.indeks')[$letter->indeks] ?? strtoupper($letter->indeks) }}</td>
                                <td class="max-w-[160px] truncate px-4 py-3 text-sm font-mono tabular-nums text-slate-800 dark:text-slate-200" title="{{ $letter->nomor_surat }}">{{ $letter->nomor_surat ?: '—' }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm text-slate-600 dark:text-slate-400">{{ $letter->tanggal_surat->format('d/m/Y') }}</td>
                                <td class="max-w-[140px] truncate px-4 py-3 text-sm text-slate-700 dark:text-slate-300" title="{{ $letter->pengirim }}">{{ $letter->pengirim }}</td>
                                <td class="max-w-xs truncate px-4 py-3 text-sm text-slate-600 dark:text-slate-400" title="{{ $letter->perihal }}">{{ $letter->perihal }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                                    <a href="{{ route('joint-letters.show', $letter) }}" class="font-medium text-teal-600 hover:text-teal-800 dark:text-teal-400">Detail</a>
                                    <span class="mx-2 text-slate-300 dark:text-slate-600">|</span>
                                    <a href="{{ route('joint-letters.edit', $letter) }}" class="font-medium text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">Edit</a>
                                    <span class="mx-2 text-slate-300 dark:text-slate-600">|</span>
                                    <form action="{{ route('joint-letters.destroy', $letter) }}" method="POST" class="inline" onsubmit="return confirm('Hapus surat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-rose-600 hover:text-rose-800 dark:text-rose-400">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data surat bersama.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($letters->hasPages())
                <div class="border-t border-slate-100 px-4 py-3 dark:border-slate-800">
                    {{ $letters->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
