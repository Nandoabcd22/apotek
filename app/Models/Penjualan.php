<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    protected $table = 'penjualans';
    protected $primaryKey = 'no_penjualan';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'no_penjualan',
        'tanggal_penjualan',
        'id_pelanggan',
        'diskon',
        'total',
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'diskon' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class, 'no_penjualan', 'no_penjualan');
    }
}
