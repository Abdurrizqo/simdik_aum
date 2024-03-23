<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'profile';
    protected $primaryKey = 'idProfile';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idProfile',
        'namaLengkap',
        'noKTAM',
        'tempatLahir',
        'tanggalLahir',
        'isMarried',
        'nipy',
        'alamat',
        'totalMasaKerja',
        'idAum',
        'fotoProfile',
        'idUser',
    ];
}
