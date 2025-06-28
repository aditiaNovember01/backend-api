<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'email',
        'nomor_telepon',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class);
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }
}
