<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiAlternatif extends Model
{
    protected $fillable = [
    'alternatif_id',
    'kriteria_id',
    'skor'
    ];
}