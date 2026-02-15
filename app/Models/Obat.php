<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Obat extends Model
{
    protected $table = 'obats';
    protected $primaryKey = 'id_obat';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id_obat',
        'nama_obat',
        'jenis',
        'satuan',
        'harga_beli',
        'harga_jual',
        'stok',
        'id_supplier',
        'tanggal_kadaluarsa',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'harga_jual' => 'decimal:2',
        'tanggal_kadaluarsa' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function penjualanDetails(): HasMany
    {
        return $this->hasMany(PenjualanDetail::class, 'id_obat', 'id_obat');
    }

    public function pembelianDetails(): HasMany
    {
        return $this->hasMany(PembelianDetail::class, 'id_obat', 'id_obat');
    }
}
