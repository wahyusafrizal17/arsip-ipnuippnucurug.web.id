<x-app-layout title="Detail Surat Bersama">
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Detail Surat Bersama</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ config('archive.indeks')[$jointLetter->indeks] ?? $jointLetter->indeks }} · {{ $jointLetter->tanggal_surat->format('d F Y') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                @if($jointLetter->file_path)
                    <a href="{{ route('joint-letters.download', $jointLetter) }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100 dark:hover:bg-slate-800">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                        Unduh PDF
                    </a>
                @endif
                <a href="{{ route('joint-letters.edit', $jointLetter) }}" class="inline-flex items-center rounded-xl bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-teal-700 dark:bg-teal-500 dark:hover:bg-teal-600">Edit</a>
                <a href="{{ route('joint-letters.index') }}" class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">Kembali</a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <dl class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
                <div class="grid gap-6">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Klasifikasi</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900 dark:text-white">{{ config('archive.klasifikasi')[$jointLetter->klasifikasi] ?? $jointLetter->klasifikasi }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Indeks</dt>
                        <dd class="mt-1 text-sm font-medium text-slate-900 dark:text-white">{{ config('archive.indeks')[$jointLetter->indeks] ?? strtoupper($jointLetter->indeks) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Pengirim / sumber</dt>
                        <dd class="mt-1 text-sm text-slate-800 dark:text-slate-200">{{ $jointLetter->pengirim }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Perihal</dt>
                        <dd class="mt-1 text-sm leading-relaxed text-slate-700 dark:text-slate-300">{{ $jointLetter->perihal }}</dd>
                    </div>
                </div>
            </dl>

            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="px-2 py-2 text-sm font-semibold text-slate-900 dark:text-white">Pratinjau dokumen</h2>
                @if($jointLetter->file_path)
                    <x-pdf-document-preview :path="$jointLetter->file_path" title="PDF Surat Bersama" />
                @else
                    <p class="mt-4 px-2 text-sm text-slate-500 dark:text-slate-400">Belum ada dokumen PDF untuk surat ini.</p>
                @endif
            </div>
        </div>

        <div class="flex justify-end border-t border-slate-200 pt-6 dark:border-slate-800">
            <form action="{{ route('joint-letters.destroy', $jointLetter) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus surat ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700 dark:bg-rose-500 dark:hover:bg-rose-600">Hapus surat</button>
            </form>
        </div>
    </div>
</x-app-layout>
