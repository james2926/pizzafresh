<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TipoEtiquetaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tipo_etiqueta')->delete();
        
        \DB::table('tipo_etiqueta')->insert(array (
            0 => 
            array (
                'nombre' => 'etiqueta 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            1 => 
            array (
                'nombre' => 'etiqueta 2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ));
        
        
    }
}