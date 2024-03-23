<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanFormal extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pedidikan_formal';
    protected $primaryKey = 'idPendidikanFormal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idPendidikanFormal',
        'lembagaPendidikan',
        'fakultas',
        'jurusanProgStud',
        'tahunLulus',
        'ijazah',
        'idUser',
    ];
}
