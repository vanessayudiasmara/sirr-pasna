<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Desa;
use App\Models\Kecamatan;

class ImportDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $file = fopen(database_path('data/desa_ponorogo.csv'), 'r');

        // skip header
        fgetcsv($file, 1000, ";");

        while(($row = fgetcsv($file, 1000, ";")) !== false){

            $kecamatan = Kecamatan::where('nama_kecamatan',$row[0])->first();

            if($kecamatan){

                Desa::create([
                    'kecamatan_id' => $kecamatan->id,
                    'nama_desa' => $row[1]
                ]);

            }

        }

        fclose($file);
    }
}


