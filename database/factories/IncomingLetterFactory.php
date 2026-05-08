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
        $orgs = array_keys(config('archive.letter_organizations', []));
        $organization = fake()->randomElement($orgs !== [] ? $orgs : ['ipnu', 'ippnu']);

        $allowed = match ($organization) {
            'ipnu' => ['ipnu', 'bersama'],
            'ippnu' => ['ippnu', 'bersama'],
            'ipnu_ippnu' => ['bersama'],
            default => ['ipnu'],
        };

        $tanggal = fake()->dateTimeBetween('-14 months');

        return [
            'indeks' => fake()->randomElement(array_keys(config('archive.indeks', []))),
            'tanggal_surat' => $tanggal->format('Y-m-d'),
            'tanggal_penerimaan' => $tanggal->format('Y-m-d'),
            'pengirim' => fake()->company(),
            'perihal' => fake()->sentence(rand(6, 14)),
            'file_path' => null,
            'organization' => $organization,
            'klasifikasi' => fake()->randomElement($allowed),
        ];
    }
}
