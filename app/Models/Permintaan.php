<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Permintaan extends Model
{
    protected $table = 'permintaan';

    protected $fillable = [
        'kode_permintaan',
        'perusahaan_id',
        'jenis',
        'posisi',
        'tgl_panggilan',
        'kuota',
        'catatan',
        'status',
        'is_locked',
        'locked_at',
        'locked_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    // ke perusahaan
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }

    // daftar kandidat
    public function details()
    {
        return $this->hasMany(PermintaanDetail::class, 'permintaan_id');
    }

    public function interviews()
    {
        return $this->hasManyThrough(
            Interview::class,
            PermintaanDetail::class,
            'permintaan_id',         // FK di permintaan_detail
            'permintaan_detail_id',  // FK di interviews
            'id',                    // PK permintaan
            'id'                     // PK permintaan_detail
        );
    }

    public function lock()
    {
        $this->update([
            'is_locked' => true,
            'locked_at' => now(),
            'locked_by' => Auth::id(),
        ]);
    }

    public function unlock()
    {
        $this->update([
            'is_locked' => false,
            'locked_at' => null,
            'locked_by' => null,
        ]);
    }
}
