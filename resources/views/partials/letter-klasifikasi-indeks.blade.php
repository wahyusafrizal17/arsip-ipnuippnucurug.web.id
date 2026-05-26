@props(['letter' => null])

@php
    $klasifikasiOptions = \App\Support\KlasifikasiOptions::forUser(auth()->user());
    $indeksOptions = config('archive.indeks', []);
    $kValRaw = old('klasifikasi', $letter?->klasifikasi);
    $kVal = $kValRaw;
    if (($kVal === null || $kVal === '') && count($klasifikasiOptions) === 1) {
        $kVal = array_key_first($klasifikasiOptions);
    }
    $iVal = old('indeks', $letter?->indeks);
@endphp

<div class="sm:col-span-2">
    <x-input-label for="klasifikasi" value="Klasifikasi" />
    <select
        id="klasifikasi"
        name="klasifikasi"
        required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
    >
        @if(count($klasifikasiOptions) > 1)
            <option value="" disabled @selected($kValRaw === null || $kValRaw === '')>Pilih klasifikasi</option>
        @endif
        @foreach($klasifikasiOptions as $value => $label)
            <option value="{{ $value }}" @selected((string) $kVal === (string) $value)>{{ $label }}</option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('klasifikasi')" />
</div>

<div>
    <x-input-label for="indeks" value="Indeks" />
    <select
        id="indeks"
        name="indeks"
        required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
    >
        <option value="" disabled @selected($iVal === null || $iVal === '')>Pilih indeks</option>
        @foreach($indeksOptions as $value => $label)
            <option value="{{ $value }}" @selected((string) $iVal === (string) $value)>{{ $label }}</option>
        @endforeach
    </select>
    <x-input-error class="mt-2" :messages="$errors->get('indeks')" />
</div>

<div class="sm:col-span-2">
    <x-input-label for="nomor_surat" value="Nomor surat" />
    <x-text-input
        id="nomor_surat"
        name="nomor_surat"
        type="text"
        class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-white"
        :value="old('nomor_surat', $letter?->nomor_surat)"
        required
        maxlength="128"
        autocomplete="off"
    />
    <x-input-error class="mt-2" :messages="$errors->get('nomor_surat')" />
</div>
