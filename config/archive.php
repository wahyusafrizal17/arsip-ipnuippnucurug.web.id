<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pilihan klasifikasi surat
    |--------------------------------------------------------------------------
    |
    | Key disimpan di database; nilai adalah label tampilan.
    |
    */

    'klasifikasi' => [
        'ipnu' => 'IPNU',
        'ippnu' => 'IPPNU',
        'bersama' => 'Bersama',
    ],

    /*
    |--------------------------------------------------------------------------
    | Organisasi arsip surat (kolom organization)
    |--------------------------------------------------------------------------
    |
    | Key disimpan di database; label untuk form admin & tabel.
    |
    */

    'letter_organizations' => [
        'ipnu' => 'IPNU',
        'ippnu' => 'IPPNU',
        'ipnu_ippnu' => 'IPNU IPPNU',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pilihan indeks surat
    |--------------------------------------------------------------------------
    */

    'indeks' => [
        'a' => 'A (internal)',
        'b' => 'B (eksternal)',
        'c' => 'C (lainnya)',
    ],
];
