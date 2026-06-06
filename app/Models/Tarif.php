<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $fillable = [
        'jenis_kendaraan',
        'harga_per_hari'
    ];

    public function parkings()
    {
        return $this->hasMany(Parking::class);
    }
}
