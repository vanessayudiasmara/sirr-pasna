<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlternatifDokumentasi extends Model
{
    protected $table = 'alternatif_dokumentasis';

    protected $fillable = [
        'alternatif_id',
        'file_path'
    ];

    public function alternatif()
    {
        return $this->belongsTo(Alternatif::class);
    }
}
