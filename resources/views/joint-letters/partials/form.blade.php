@props(['jointLetter' => null])

@php($editing = $jointLetter !== null)

<form
    method="POST"
    action="{{ $editing ? route('joint-letters.update', $jointLetter) : route('joint-letters.store') }}"
    enctype="multipart/form-data"
    class="space-y-6"
>
    @csrf
    @if($editing)
        @method('PUT')
    @endif

    <div class="grid gap-6 sm:grid-cols-2">
        @include('partials.letter-klasifikasi-indeks', ['letter' => $jointLetter])

        <div>
            <x-input-label for="tanggal_surat" value="Tanggal surat" />
            <x-text-input id="tanggal_surat" name="tanggal_surat" type="date" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-white" :value="old('tanggal_surat', $jointLetter?->tanggal_surat?->format('Y-m-d'))" required />
            <x-input-error class="mt-2" :messages="$errors->get('tanggal_surat')" />
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="pengirim" value="Pengirim / sumber surat" />
            <x-text-input id="pengirim" name="pengirim" type="text" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-white" :value="old('pengirim', $jointLetter?->pengirim)" required />
            <x-input-error class="mt-2" :messages="$errors->get('pengirim')" />
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="perihal" value="Perihal" />
            <textarea id="perihal" name="perihal" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">{{ old('perihal', $jointLetter?->perihal) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('perihal')" />
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="file_dokumen" value="Dokumen PDF" />
            @if($editing && $jointLetter->file_path)
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Berkas saat ini:
                    <a href="{{ route('joint-letters.download', $jointLetter) }}" class="font-medium text-teal-600 hover:underline dark:text-teal-400">Unduh PDF</a>
                </p>
            @endif
            <input
                id="file_dokumen"
                name="file_dokumen"
                type="file"
                accept="application/pdf,.pdf"
                @unless($editing) required @endunless
                class="mt-2 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-teal-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-teal-700 hover:file:bg-teal-100 dark:text-slate-300 dark:file:bg-teal-950 dark:file:text-teal-300 dark:hover:file:bg-teal-900"
            />
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Maks. 10 MB. Format PDF.@if($editing) Kosongkan jika tidak mengganti berkas.@endif</p>
            <x-input-error class="mt-2" :messages="$errors->get('file_dokumen')" />
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <x-primary-button>{{ $editing ? 'Perbarui' : 'Simpan' }}</x-primary-button>
        <a href="{{ $editing ? route('joint-letters.show', $jointLetter) : route('joint-letters.index') }}" class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">Batal</a>
    </div>
</form>
