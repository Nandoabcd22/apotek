<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'suppliers';
    protected $primaryKey = 'id_supplier';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id_supplier',
        'nama_supplier',
        'alamat',
        'kota',
        'telepon',
    ];

    public function obats(): HasMany
    {
        return $this->hasMany(Obat::class, 'id_supplier', 'id_supplier');
    }

    public function pembelians(): HasMany
    {
        return $this->hasMany(Pembelian::class, 'id_supplier', 'id_supplier');
    }
}
