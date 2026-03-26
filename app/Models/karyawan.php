<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'nip',
        'jabatan',
        'departemen',
        'no_hp',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // Relasi ke User (1:1)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
