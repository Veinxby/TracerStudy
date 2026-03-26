<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerja extends Model
{
    use HasFactory;

    protected $table = 'kerja';

    protected $fillable = [
        'permintaan_id',
        'user_id',
        'perusahaan_id',
        'posisi',
        'tipe_kontrak',
        'tgl_mulai',
        'tgl_selesai',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'permintaan_id');
    }
}
