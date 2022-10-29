<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status',
        'lat',
        'long',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'ket',
        'surat_sakit',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
