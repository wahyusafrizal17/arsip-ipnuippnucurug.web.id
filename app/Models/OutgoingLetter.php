<?php

namespace App\Models;

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

        return $query->where(function (Builder $q) use ($term) {
            $q->where('penerima', 'like', '%'.$term.'%')
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
