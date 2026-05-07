<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JointLetter extends Model
{
    /** @use HasFactory<\Database\Factories\JointLetterFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'klasifikasi',
        'indeks',
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

        return $query->where(function (Builder $q) use ($term) {
            $q->where('pengirim', 'like', '%'.$term.'%')
                ->orWhere('perihal', 'like', '%'.$term.'%')
                ->orWhere('indeks', 'like', '%'.$term.'%')
                ->orWhere('klasifikasi', 'like', '%'.$term.'%');
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
