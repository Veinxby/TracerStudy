<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'nipd',
        'jk',
        'no_hp',
        'status_akademik',
        'status_kerja',
        'ipk',
        'domisili',
    ];

    /* ================= RELATIONS ================= */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class, 'mahasiswa_id')->orderBy('tgl_interview', 'desc');
    }

    public function penempatan()
    {
        return $this->hasMany(Penempatan::class, 'mahasiswa_id');
    }

    public function permintaanDetails()
    {
        return $this->hasMany(PermintaanDetail::class, 'mahasiswa_id');
    }
}
