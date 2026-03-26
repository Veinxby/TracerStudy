<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $table = 'interviews';

    protected $fillable = [
        'permintaan_detail_id',
        'mahasiswa_id',
        'perusahaan_id',
        'tgl_interview',
        'posisi',
        'metode',
        'hasil',
        'alasan_gagal',
        'keterangan'
    ];

    /* ================= RELATIONS ================= */

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function permintaanDetail()
    {
        return $this->belongsTo(PermintaanDetail::class, 'permintaan_detail_id');
    }
}
