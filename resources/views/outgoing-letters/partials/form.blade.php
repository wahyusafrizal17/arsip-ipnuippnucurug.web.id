@props(['outgoingLetter' => null, 'defaultOrg' => null])

@php($editing = $outgoingLetter !== null)
@php($orgValue = old('organization', $outgoingLetter?->organization ?? $defaultOrg))

<form
    method="POST"
    action="{{ $editing ? route('outgoing-letters.update', $outgoingLetter) : route('outgoing-letters.store') }}"
    enctype="multipart/form-data"
    class="space-y-6"
>
    @csrf
    @if($editing)
        @method('PUT')
    @endif

    <div class="grid gap-6 sm:grid-cols-2">
        @if(auth()->user()->isAdmin())
            <div class="sm:col-span-2">
                <x-input-label for="organization" value="Organisasi (arsip)" />
                <select id="organization" name="organization" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                    @foreach(config('archive.letter_organizations', []) as $value => $label)
                        <option value="{{ $value }}" @selected($orgValue === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('organization')" />
            </div>
        @endif
        @include('partials.letter-klasifikasi-indeks', ['letter' => $outgoingLetter])

        <div>
            <x-input-label for="tanggal_surat" value="Tanggal surat" />
            <x-text-input id="tanggal_surat" name="tanggal_surat" type="date" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-white" :value="old('tanggal_surat', $outgoingLetter?->tanggal_surat?->format('Y-m-d') ?: (! $editing ? now()->format('Y-m-d') : ''))" required />
            <x-input-error class="mt-2" :messages="$errors->get('tanggal_surat')" />
        </div>

        <div>
            <x-input-label for="tanggal_pengiriman" value="Tanggal pengiriman surat" />
            <x-text-input id="tanggal_pengiriman" name="tanggal_pengiriman" type="date" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-white" :value="old('tanggal_pengiriman', $outgoingLetter?->tanggal_pengiriman?->format('Y-m-d') ?: (! $editing ? now()->format('Y-m-d') : ''))" required />
            <x-input-error class="mt-2" :messages="$errors->get('tanggal_pengiriman')" />
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="penerima" value="Penerima" />
            <x-text-input id="penerima" name="penerima" type="text" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-white" :value="old('penerima', $outgoingLetter?->penerima)" required />
            <x-input-error class="mt-2" :messages="$errors->get('penerima')" />
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="perihal" value="Perihal" />
            <textarea id="perihal" name="perihal" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">{{ old('perihal', $outgoingLetter?->perihal) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('perihal')" />
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="file_dokumen" value="Dokumen PDF" />
            @if($editing && $outgoingLetter->file_path)
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                    Berkas saat ini:
                    <a href="{{ route('outgoing-letters.download', $outgoingLetter) }}" class="font-medium text-indigo-600 hover:underline dark:text-indigo-400">Unduh PDF</a>
                </p>
            @endif
            <input
                id="file_dokumen"
                name="file_dokumen"
                type="file"
                accept="application/pdf,.pdf"
                @unless($editing) required @endunless
                class="mt-2 block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 dark:text-slate-300 dark:file:bg-indigo-950 dark:file:text-indigo-300 dark:hover:file:bg-indigo-900"
            />
            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Maks. 10 MB. Format PDF.@if($editing) Kosongkan jika tidak mengganti berkas.@endif</p>
            <x-input-error class="mt-2" :messages="$errors->get('file_dokumen')" />
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <x-primary-button>{{ $editing ? 'Perbarui' : 'Simpan' }}</x-primary-button>
        <a href="{{ $editing ? route('outgoing-letters.show', $outgoingLetter) : route('outgoing-letters.index') }}" class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">Batal</a>
    </div>
</form>
