<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iuran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe_pembayaran',
        'jenis',
        'bukti',
        'status',
        'file_pendukung',
        'file_surat',
    ];
}
