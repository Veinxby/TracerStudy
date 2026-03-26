<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'nama',
        'degree',
        'lama_studi',
    ];

    /* ================= RELATIONS ================= */

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}
