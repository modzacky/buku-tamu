<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'nama',
    'nomor_hp',
    'email',
    'instansi',
    'tujuan_kunjungan',
    'tanggal_kunjungan',
    'sumber',
])]
class Guest extends Model
{
    /** @use HasFactory<\Database\Factories\GuestFactory> */
    use HasFactory;

    public const SUMBER = ['direct', 'whatsapp', 'instagram', 'facebook'];

    protected $table = 'guests';

    protected function casts(): array
    {
        return [
            'tanggal_kunjungan' => 'date',
        ];
    }

    /** Cari tamu berdasarkan nama (pencarian tidak peka huruf besar/kecil). */
    public function scopeCariNama(Builder $query, ?string $keyword): Builder
    {
        if ($keyword !== null && $keyword !== '') {
            $query->where('nama', 'like', '%' . $keyword . '%');
        }

        return $query;
    }

    /** Tamu yang berkunjung pada bulan tertentu (default: bulan ini). */
    public function scopePadaBulan(Builder $query, ?int $tahun = null, ?int $bulan = null): Builder
    {
        $tahun ??= now()->year;
        $bulan ??= now()->month;

        return $query->whereYear('tanggal_kunjungan', $tahun)
            ->whereMonth('tanggal_kunjungan', $bulan);
    }
}
