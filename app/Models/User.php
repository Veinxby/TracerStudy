<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nama',
        'username',
        'email',
        'password',
        'role',
        'is_active'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ================= RELATIONS ================= */

    public function Mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }


    public function karyawan()
    {
        return $this->hasOne(Karyawan::class, 'user_id');
    }


    public function hasRole($roles)
    {
        return in_array($this->role, (array) $roles);
    }

    public function hasPermission($permission)
    {
        $permissions = [

            'adm_tracer' => [
                'mahasiswa.view',
                // Interview
                'interview.import',

                // Penempatan
                'penempatan.create',
                'penempatan.import',
                'penempatan.updateStatus',
            ],

            'educ' => [
                'mahasiswa.view',
                'mahasiswa.create',
                'mahasiswa.edit',
                'mahasiswa.delete',
                'mahasiswa.import',
                'mahasiswa.export',

                'jurusan.create'
            ],

            'it' => [
                'mahasiswa.view',
                'mahasiswa.create',
                'mahasiswa.edit',
                'mahasiswa.delete',
                'mahasiswa.import',
                'mahasiswa.export',
                'interview.import',

                'jurusan.create',

                'penempatan.create',
                'penempatan.import',
                'penempatan.updateStatus',

                'user.manage',
            ],
        ];

        return in_array($permission, $permissions[$this->role] ?? []);
    }
}
