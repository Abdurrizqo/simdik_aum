<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasTambahan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'tugas_tambahan';
    protected $primaryKey = 'idTugasTambahan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'idTugasTambahan',
        'tugasTambahan',
        'idUser',
    ];
}
