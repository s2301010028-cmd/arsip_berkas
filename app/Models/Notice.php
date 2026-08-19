<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'tanggal',
        'lokasi',
        'petugas_pagi',
        'awal_pagi',
        'akhir_pagi',
        'jumlah_pagi',
        'status_pagi',
        'keterangan_pagi',
        'petugas_sore',
        'awal_sore',
        'akhir_sore',
        'jumlah_sore',
        'status_sore',
        'keterangan_sore',
    ];
}
