<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aum extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'aum';
    protected $primaryKey = 'idAum';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idAum',
        'namaAum',
        'npsm',
        'lokasi',
        'izinTambahPegawai',
    ];
}
