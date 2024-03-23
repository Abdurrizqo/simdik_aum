<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    protected $primaryKey = 'idUser';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idUser',
        'nickname',
        'username',
        'password',
        'isProfileDone',
        'role',
        'status',
        'idAum',
        'isActive',
        'idProfile',
        'idTugasPokok',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pedidikanFormal(): HasMany
    {
        return $this->hasMany(PendidikanFormal::class, 'idUser', 'idUser');
    }

    public function pedidikanNonFormal(): HasMany
    {
        return $this->hasMany(PendidikanNonFormal::class, 'idUser', 'idUser');
    }

    public function riwayatPekerjaan(): HasMany
    {
        return $this->hasMany(RiwayatPekerjaan::class, 'idUser', 'idUser');
    }

    public function tugasTambahan(): HasMany
    {
        return $this->hasMany(TugasTambahan::class, 'idUser', 'idUser');
    }

    public function TugasMapel(): HasMany
    {
        return $this->hasMany(TugasMapel::class, 'idUser', 'idUser');
    }
}
