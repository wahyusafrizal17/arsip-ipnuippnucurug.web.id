<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inventory>
 */
class InventoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'organization' => fake()->randomElement(array_keys(config('archive.letter_organizations', [
                'ipnu' => 'IPNU',
                'ippnu' => 'IPPNU',
                'ipnu_ippnu' => 'IPNU IPPNU',
            ]))),
            'nama_barang' => fake()->words(rand(2, 4), true),
            'jumlah' => fake()->numberBetween(1, 500),
            'status_barang' => fake()->randomElement(['baik', 'rusak', 'hilang']),
            'lokasi_penyimpanan' => fake()->randomElement(['Rak A1', 'Rak A2', 'Rak B1', 'Gudang Utama', 'Lemari Arsip']),
        ];
    }
}
