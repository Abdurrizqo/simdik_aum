<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasPokok extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tugas_pokok';
    protected $primaryKey = 'idTugasPokok';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idTugasPokok',
        'tugasPokok',
        'namaAUm',
        'nomerAum',
        'namaPenandatangan',
        'jabatanPenandatangan',
        'nomerSK',
        'tanggalSK',
        'buktisk',
        'idUser',
    ];
}
