@props(['inventory' => null])

@php($editing = $inventory !== null)

<form method="POST" action="{{ $editing ? route('inventories.update', $inventory) : route('inventories.store') }}" class="space-y-6">
    @csrf
    @if($editing)
        @method('PUT')
    @endif

    <div class="grid gap-6 sm:grid-cols-2">
        @if(auth()->user()->isAdmin())
            <div class="sm:col-span-2">
                <x-input-label for="organization" value="Organisasi" />
                <select id="organization" name="organization" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                    @foreach(config('archive.letter_organizations', []) as $key => $label)
                        <option value="{{ $key }}" @selected(old('organization', $inventory?->organization ?? 'ipnu') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('organization')" />
            </div>
        @endif

        <div class="sm:col-span-2">
            <x-input-label for="nama_barang" value="Nama barang" />
            <x-text-input id="nama_barang" name="nama_barang" type="text" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-white" :value="old('nama_barang', $inventory?->nama_barang)" required />
            <x-input-error class="mt-2" :messages="$errors->get('nama_barang')" />
        </div>

        <div>
            <x-input-label for="jumlah" value="Jumlah" />
            <x-text-input id="jumlah" name="jumlah" type="number" min="0" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-white" :value="old('jumlah', $inventory?->jumlah ?? 0)" required />
            <x-input-error class="mt-2" :messages="$errors->get('jumlah')" />
        </div>

        <div>
            <x-input-label for="status_barang" value="Status barang" />
            <select id="status_barang" name="status_barang" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
                @foreach(['baik' => 'Baik', 'rusak' => 'Rusak', 'hilang' => 'Hilang'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status_barang', $inventory?->status_barang) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status_barang')" />
        </div>

        <div class="sm:col-span-2">
            <x-input-label for="lokasi_penyimpanan" value="Lokasi penyimpanan" />
            <x-text-input id="lokasi_penyimpanan" name="lokasi_penyimpanan" type="text" class="mt-1 block w-full dark:bg-slate-900 dark:border-slate-700 dark:text-white" :value="old('lokasi_penyimpanan', $inventory?->lokasi_penyimpanan)" required />
            <x-input-error class="mt-2" :messages="$errors->get('lokasi_penyimpanan')" />
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        <x-primary-button>{{ $editing ? 'Perbarui' : 'Simpan' }}</x-primary-button>
        <a href="{{ route('inventories.index') }}" class="inline-flex items-center rounded-md border border-slate-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800">Batal</a>
    </div>
</form>
