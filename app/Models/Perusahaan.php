<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $fillable = [
        'nama_perusahaan',
        'bidang_usaha',
        'email',
        'no_telepon',
        'alamat',
        'status_mitra'
    ];

    /* ================= RELATIONS ================= */

    public function penempatan()
    {
        return $this->hasMany(Penempatan::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    public function permintaan()
    {
        return $this->hasMany(Permintaan::class, 'perusahaan_id');
    }
}
