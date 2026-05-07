<x-app-layout title="Tambah Surat Keluar">
    <div class="mx-auto max-w-3xl">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
            <h1 class="text-xl font-bold text-slate-900 dark:text-white">Tambah Surat Keluar</h1>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Lengkapi formulir berikut.</p>
            <div class="mt-8">
                @include('outgoing-letters.partials.form', ['defaultOrg' => $defaultOrg ?? null])
            </div>
        </div>
    </div>
</x-app-layout>
