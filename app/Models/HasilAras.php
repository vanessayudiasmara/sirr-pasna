<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilAras extends Model
{
    protected $fillable = [
        'alternatif_id',
        'nilai_normalisasi',
        'nilai_preferensi',
        'ranking'
    ];
    
    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class, 'alternatif_id');
    }
}

