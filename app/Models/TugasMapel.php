<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasMapel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tugas_mapel';
    protected $primaryKey = 'idTugasMapel';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idTugasMapel',
        'mapelDiampu',
        'totalJamSeminggu',
        'idUser',
    ];
}
