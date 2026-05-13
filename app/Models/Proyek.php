<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Alternatif;

class Proyek extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_kejadian',
        'jenis_bencana',
        'nama_proyek',
        'lokasi',
        'penanggung_jawab',
        'tanggal_update',
        'status',
        'keterangan',
    ];

    // RELASI KE DATA KERUSAKAN (Alternatif)
        public function alternatif()
        {
            return $this->belongsTo(Alternatif::class);
        }
}
