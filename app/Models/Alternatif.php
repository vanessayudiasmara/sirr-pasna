<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Proyek;
use App\Models\AlternatifDokumentasi;
use App\Models\HasilAras;
use App\Models\NilaiAlternatif;

class Alternatif extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tanggal',
        'jenis_bencana',
        'nama_proyek',
        'lokasi',
        'kecamatan',
        'desa',
        'jenis_infrastruktur',
        'volume_kerusakan',
        'satuan_volume',
        'estimasi_masyarakat',
        'estimasi_pemerintah',
        'estimasi_biaya',
        'kewenangan_aset',
        'korban_terdampak',
        'keterangan',
        'status',
    ];

    public function dokumentasis()
    {
        return $this->hasMany(AlternatifDokumentasi::class);
    }

    public function proyek()
    {
        return $this->hasOne(Proyek::class);
    }

    public function hasilAras()
    {
        return $this->hasOne(HasilAras::class, 'alternatif_id');
    }

    public function nilaiAlternatifs()
    {
        return $this->hasMany(NilaiAlternatif::class);
    }
}
