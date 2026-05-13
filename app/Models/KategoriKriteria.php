<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKriteria extends Model
{
    protected $fillable = [
        'kriteria_id',
        'nama_kategori',
        'satuan',
        'nilai',
        'min_value',
        'max_value',
    ];

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}


