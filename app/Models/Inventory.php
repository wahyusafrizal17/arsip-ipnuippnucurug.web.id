<?php

namespace App\Models;

use Database\Factories\InventoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    /** @use HasFactory<InventoryFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'organization',
        'nama_barang',
        'jumlah',
        'status_barang',
        'lokasi_penyimpanan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
        ];
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('nama_barang', 'like', '%'.$term.'%')
                ->orWhere('lokasi_penyimpanan', 'like', '%'.$term.'%')
                ->orWhere('status_barang', 'like', '%'.$term.'%');
        });
    }
}
