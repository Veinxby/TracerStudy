<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'id',
        'jurusan_id',
        'kode_kelas',
        'tahun_masuk'
    ];

    /* ================= RELATIONS ================= */

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'kelas_id', 'id');
    }
}
