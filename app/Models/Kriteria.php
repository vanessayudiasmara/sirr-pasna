<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubKriteria;

class Kriteria extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kriteria',
        'field_name',
        'jenis',
        'bobot',
        'satuan',
        'deskripsi',
        'min_value',
        'max_value',
        'tipe_input',
    ];

    public function subKriterias()
    {
        return $this->hasMany(SubKriteria::class);
    }


}
