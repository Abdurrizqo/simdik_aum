<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendidikanNonFormal extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'pedidikan_non_formal';
    protected $primaryKey = 'idPendidikanNonFormal';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idPendidikanNonFormal',
        'lembagaPenyelenggara',
        'jenisDiklat',
        'tingkat',
        'tahunLulus',
        'sertifikat',
        'idUser',
    ];
}
