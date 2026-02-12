<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembelian extends Model
{
    protected $table = 'pembelians';
    protected $primaryKey = 'no_pembelian';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'no_pembelian',
        'tanggal_pembelian',
        'id_supplier',
        'diskon',
        'total',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'diskon' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PembelianDetail::class, 'no_pembelian', 'no_pembelian');
    }
}
