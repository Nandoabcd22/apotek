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
        'user_id',
        'total',
    ];

    protected $casts = [
        'tanggal_penjualan' => 'date',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class, 'no_penjualan', 'no_penjualan');
    }
}
