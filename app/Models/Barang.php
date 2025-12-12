<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    protected $fillable = [
        'barang',
        'kategori_id',
        'harga_beli',
        'harga_jual',
        'stok',
        'satuan',
        'deskripsi'
    ];

    protected $casts = [
        'harga_beli' => 'integer',
        'harga_jual' => 'integer',
        'stok' => 'integer',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    // Accessor untuk format harga
    public function getHargaBeliFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
    }

    public function getHargaJualFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }

    // Hitung keuntungan
    public function getKeuntunganAttribute(): int
    {
        return $this->harga_jual - $this->harga_beli;
    }

    public function getKeuntunganFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->keuntungan, 0, ',', '.');
    }

    // Hitung total nilai stok
    public function getNilaiStokAttribute(): int
    {
        return $this->harga_beli * $this->stok;
    }

    public function getNilaiStokFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->nilai_stok, 0, ',', '.');
    }
}
