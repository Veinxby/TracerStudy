<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penempatan extends Model
{
    use HasFactory;

    protected $table = 'penempatan';

    protected $fillable = [
        'permintaan_detail_id',
        'mahasiswa_id',
        'perusahaan_id',
        'jenis',
        'posisi',
        'tipe_kontrak',
        'tgl_mulai',
        'tgl_selesai',
        'status',
        'sumber',
        'keterangan'
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */


    public function permintaanDetail()
    {
        return $this->belongsTo(PermintaanDetail::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    /*
    |--------------------------------------------------------------------------
    | TOOLS
    |--------------------------------------------------------------------------
    */

    public function scopeMagang($query)
    {
        return $query->where('jenis', 'magang');
    }

    public function scopeKerja($query)
    {
        return $query->where('jenis', 'kerja');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
}
