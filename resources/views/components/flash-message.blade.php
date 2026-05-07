@if(session('success'))
    <div
        role="alert"
        class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 shadow-sm dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-100"
    >
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div
        role="alert"
        class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900 shadow-sm dark:border-rose-900 dark:bg-rose-950 dark:text-rose-100"
    >
        {{ session('error') }}
    </div>
@endif
