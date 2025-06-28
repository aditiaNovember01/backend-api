<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_kamar',
        'kapasitas_tamu',
        'fasilitas_kamar',
        'harga_per_malam',
        'jumlah_kamar_tersedia',
        'foto_kamar',
    ];
}
