<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccionLogTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('accion_log')->delete();
        
        \DB::table('accion_log')->insert(array (
            0 => 
            array (
                'nombre' => 'Ha ingresado al sistema',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            1 => 
            array (
                'nombre' => 'Se ha deslogueado',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ));
        
        
    }
}