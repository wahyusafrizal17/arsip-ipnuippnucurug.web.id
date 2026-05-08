<?php

namespace Database\Seeders;

use App\Models\JointLetter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class JointLetterSeeder extends Seeder
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

        JointLetter::factory()
            ->count(6)
            ->state(['klasifikasi' => 'bersama'])
            ->create()
            ->each(function (JointLetter $letter) use ($pdf) {
                $path = 'joint_letters/sb-'.$letter->id.'.pdf';
                Storage::disk('public_web')->put($path, $pdf);
                $letter->update(['file_path' => $path]);
            });
    }
}
