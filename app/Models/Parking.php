<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $fillable = [
        'kode_unik',
        'plat_nomor',
        'tarif_id',
        'waktu_masuk',
        'waktu_keluar',
        'total_bayar'
    ];

    public function tarif()
    {
        return $this->belongsTo(Tarif::class);
    }
}
