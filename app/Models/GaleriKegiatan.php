<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kegiatan_id',
        'gambar',
    ];

    public function kegiatans(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Kegiatan::class, 'kegiatan_id', 'id');
    }

}