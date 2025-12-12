<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $fillable = ['name', 'deskripsi'];

    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class);
    }

    // Hitung jumlah barang per kategori
    public function getJumlahBarangAttribute(): int
    {
        return $this->barangs()->count();
    }

    // Hitung total stok per kategori
    public function getTotalStokAttribute(): int
    {
        return $this->barangs()->sum('stok');
    }
}
