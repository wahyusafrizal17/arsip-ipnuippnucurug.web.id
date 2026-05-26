<?php

namespace App\Models;

use App\Support\ArchiveSearch;
use Database\Factories\JointLetterFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JointLetter extends Model
{
    /** @use HasFactory<JointLetterFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'klasifikasi',
        'indeks',
        'nomor_surat',
        'tanggal_surat',
        'pengirim',
        'perihal',
        'file_path',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
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
                ->orWhere('pengirim', 'like', '%'.$term.'%')
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

    public function scopeTanggalBetween(Builder $query, ?string $from, ?string $to): Builder
    {
        if ($from) {
            $query->whereDate('tanggal_surat', '>=', $from);
        }

        if ($to) {
            $query->whereDate('tanggal_surat', '<=', $to);
        }

        return $query;
    }
}
