<x-app-layout title="Inventaris">
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Inventaris</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Kelola barang dengan status dan lokasi penyimpanan.</p>
            </div>
            <a href="{{ route('inventories.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Tambah barang
            </a>
        </div>

        <form method="GET" action="{{ route('inventories.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <label for="q" class="block text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Cari barang</label>
            <div class="mt-2 flex flex-wrap gap-2">
                <input id="q" name="q" type="search" value="{{ request('q') }}" placeholder="Nama, lokasi, status..." class="block min-w-[200px] flex-1 rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-950 dark:text-white" />
                <input type="hidden" name="sort" value="{{ $sort }}" />
                <input type="hidden" name="direction" value="{{ $direction }}" />
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-200">Cari</button>
                <a href="{{ route('inventories.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">Reset</a>
            </div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                    <thead class="bg-slate-50 dark:bg-slate-950/60">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">
                                @php
                                    $nextDirection = ($sort === 'nama_barang' && $direction === 'asc') ? 'desc' : 'asc';
                                    $qs = array_merge(request()->except('page'), ['sort' => 'nama_barang', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('inventories.index', $qs) }}" class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400">
                                    Nama barang
                                    @if($sort === 'nama_barang')
                                        <span class="tabular-nums text-[10px]">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">
                                @php
                                    $nextDirection = ($sort === 'jumlah' && $direction === 'asc') ? 'desc' : 'asc';
                                    $qs = array_merge(request()->except('page'), ['sort' => 'jumlah', 'direction' => $nextDirection]);
                                @endphp
                                <a href="{{ route('inventories.index', $qs) }}" class="inline-flex items-center gap-1 hover:text-emerald-600 dark:hover:text-emerald-400">
                                    Jumlah
                                    @if($sort === 'jumlah')
                                        <span class="tabular-nums text-[10px]">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Status</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Lokasi</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-600 dark:text-slate-400">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($items as $item)
                            @php
                                $badge = match ($item->status_barang) {
                                    'baik' => 'bg-emerald-100 text-emerald-800 ring-emerald-600/20 dark:bg-emerald-950 dark:text-emerald-200 dark:ring-emerald-600/40',
                                    'rusak' => 'bg-amber-100 text-amber-900 ring-amber-600/20 dark:bg-amber-950 dark:text-amber-200 dark:ring-amber-600/40',
                                    default => 'bg-rose-100 text-rose-800 ring-rose-600/20 dark:bg-rose-950 dark:text-rose-200 dark:ring-rose-600/40',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                                <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">{{ $item->nama_barang }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm tabular-nums text-slate-700 dark:text-slate-300">{{ number_format($item->jumlah) }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-sm">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $badge }}">{{ ucfirst($item->status_barang) }}</span>
                                </td>
                                <td class="max-w-[180px] truncate px-4 py-3 text-sm text-slate-600 dark:text-slate-400" title="{{ $item->lokasi_penyimpanan }}">{{ $item->lokasi_penyimpanan }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-right text-sm">
                                    <a href="{{ route('inventories.edit', $item) }}" class="font-medium text-emerald-700 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300">Edit</a>
                                    <span class="mx-2 text-slate-300 dark:text-slate-600">|</span>
                                    <form action="{{ route('inventories.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus barang ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-rose-600 hover:text-rose-800 dark:text-rose-400">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data inventaris.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($items->hasPages())
                <div class="border-t border-slate-100 px-4 py-3 dark:border-slate-800">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
