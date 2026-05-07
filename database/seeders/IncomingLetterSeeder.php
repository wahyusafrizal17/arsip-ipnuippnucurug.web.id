<?php

namespace Database\Seeders;

use App\Models\IncomingLetter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class IncomingLetterSeeder extends Seeder
{
    public function run(): void
    {
        $fixture = database_path('fixtures/sample.pdf');
        if (! is_readable($fixture)) {
            throw new RuntimeException('Berkas demo tidak ada: '.$fixture);
        }

        $pdf = file_get_contents($fixture);
        if ($pdf === false) {
            throw new RuntimeException('Gagal membaca: '.$fixture);
        }

        $letters = IncomingLetter::factory()
            ->count(6)
            ->state(['organization' => 'ipnu'])
            ->create()
            ->concat(
                IncomingLetter::factory()
                    ->count(6)
                    ->state(['organization' => 'ippnu'])
                    ->create()
            );

        $letters->each(function (IncomingLetter $letter) use ($pdf) {
            $path = 'incoming_letters/sm-'.$letter->id.'.pdf';
            Storage::disk('public_web')->put($path, $pdf);
            $letter->update(['file_path' => $path]);
        });
    }
}
