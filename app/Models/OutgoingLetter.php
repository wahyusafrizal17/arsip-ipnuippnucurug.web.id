<?php

namespace App\Models;

use App\Support\ArchiveSearch;
use Database\Factories\OutgoingLetterFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutgoingLetter extends Model
{
    /** @use HasFactory<OutgoingLetterFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'organization',
        'klasifikasi',
        'indeks',
        'nomor_surat',
        'tanggal_surat',
        'tanggal_pengiriman',
        'penerima',
        'perihal',
        'file_path',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'tanggal_pengiriman' => 'date',
        ];
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        $indeksKeys = ArchiveSearch::keysMatchingLabelOrKey('archive.indeks', $term);
        $klasifikasiKeys = ArchiveSearch::keysMatchingLabelOrKey('archive.klasifikasi', $term);

        return $query->where(function (Builder $q) use ($term, $indeksKeys, $klasifikasiKeys) {
            $q->where('nomor_surat', 'like', '%'.$term.'%')
                ->orWhere('penerima', 'like', '%'.$term.'%')
                ->orWhere('perihal', 'like', '%'.$term.'%')
                ->orWhere('indeks', 'like', '%'.$term.'%')
                ->orWhere('klasifikasi', 'like', '%'.$term.'%');

            if ($indeksKeys !== []) {
                $q->orWhereIn('indeks', $indeksKeys);
            }

            if ($klasifikasiKeys !== []) {
                $q->orWhereIn('klasifikasi', $klasifikasiKeys);
            }
        });
    }

    /**
     * Rentang tanggal mengikuti tanggal pengiriman (prioritas); jika kosong dipakai tanggal surat.
     */
    public function scopeTanggalBetween(Builder $query, ?string $from, ?string $to): Builder
    {
        if ($from) {
            $query->whereRaw('COALESCE(tanggal_pengiriman, tanggal_surat) >= ?', [$from]);
        }

        if ($to) {
            $query->whereRaw('COALESCE(tanggal_pengiriman, tanggal_surat) <= ?', [$to]);
        }

        return $query;
    }
}
