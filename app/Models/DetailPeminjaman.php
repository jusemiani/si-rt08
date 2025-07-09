<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'jumlah_dipinjam',
        'jumlah_kembali',
    ];

    public function peminjamen(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Peminjaman::class, 'peminjaman_id', 'id');
    }

    public function barangs(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Barang::class, 'barang_id', 'id');
    }

}