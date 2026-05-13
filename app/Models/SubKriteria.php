<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kriteria;

class SubKriteria extends Model
{
    protected $table = 'sub_kriterias';

    protected $fillable = [
        'kriteria_id',
        'nama',
        'skor',
        'min_value',
        'max_value',
        'satuan'
    ];


    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}