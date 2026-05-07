<?php

namespace Database\Seeders;

use App\Models\OutgoingLetter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class OutgoingLetterSeeder extends Seeder
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

        OutgoingLetter::factory()
            ->count(10)
            ->create()
            ->each(function (OutgoingLetter $letter) use ($pdf) {
                $path = 'outgoing_letters/sk-'.$letter->id.'.pdf';
                Storage::disk('public_web')->put($path, $pdf);
                $letter->update(['file_path' => $path]);
            });
    }
}
