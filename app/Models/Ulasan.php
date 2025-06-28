<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'kamar_id',
        'rating',
        'komentar',
        'tanggal_review',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }
}
