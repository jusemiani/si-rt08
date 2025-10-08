<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Iuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipe_pembayaran',
        'jenis',
        'bukti',
        'jumlah',
        'status',
    ];

    protected static function booted()
    {
        static::created(function ($iuran) {
            Pemasukan::create([
                'tanggal' => now(),
                'sumber' => $iuran->jenis,
                'jumlah' =>  $iuran->jumlah ?? 0, // Pastikan kolom jumlah tersedia
                'keterangan' => 'Pemasukan otomatis dari iuran: ' . $iuran->jenis,
                'user_id' => $iuran->user_id ?? Auth::user()->id,
            ]);
        });
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}
