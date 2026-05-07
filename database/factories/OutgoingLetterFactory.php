<?php

namespace Database\Factories;

use App\Models\OutgoingLetter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OutgoingLetter>
 */
class OutgoingLetterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'klasifikasi' => fake()->randomElement(array_keys(config('archive.klasifikasi', []))),
            'indeks' => fake()->randomElement(array_keys(config('archive.indeks', []))),
            'tanggal_surat' => fake()->dateTimeBetween('-14 months')->format('Y-m-d'),
            'penerima' => fake()->company(),
            'perihal' => fake()->sentence(rand(6, 14)),
            'file_path' => null,
            'organization' => fake()->randomElement(['ipnu', 'ippnu']),
        ];
    }
}
