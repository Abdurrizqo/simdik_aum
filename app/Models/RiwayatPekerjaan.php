<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPekerjaan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'riwayat_pekerjaan';
    protected $primaryKey = 'idRiwayatPekerjaan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idRiwayatPekerjaan',
        'namaAum',
        'nomerAum',
        'namaPenandatangan',
        'jabatanPenandaTangan',
        'nomerSK',
        'masaKerjaDalamBulan',
        'tanggalSK',
        'buktiSK',
        'idUser',
    ];
}
