<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanDetail extends Model
{
    protected $table = 'permintaan_detail';

    protected $fillable = [
        'permintaan_id',
        'mahasiswa_id',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'permintaan_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class, 'permintaan_detail_id');
    }

    public function penempatan()
    {
        return $this->hasOne(Penempatan::class, 'permintaan_detail_id');
    }
}
