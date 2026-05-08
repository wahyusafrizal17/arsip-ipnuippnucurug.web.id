<?php

namespace Database\Factories;

use App\Models\IncomingLetter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IncomingLetter>
 */
class IncomingLetterFactory extends Factory
{
    public function definition(): array
    {
        return [
            'indeks' => fake()->randomElement(array_keys(config('archive.indeks', []))),
            'tanggal_surat' => fake()->dateTimeBetween('-14 months')->format('Y-m-d'),
            'pengirim' => fake()->company(),
            'perihal' => fake()->sentence(rand(6, 14)),
            'file_path' => null,
            'organization' => $org = fake()->randomElement(array_keys(config('archive.letter_organizations', ['ipnu' => '', 'ippnu' => '']))),
            'klasifikasi' => $org,
        ];
    }
}
