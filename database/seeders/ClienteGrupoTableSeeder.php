<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ClienteGrupoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cliente_grupo')->delete();
        
        \DB::table('cliente_grupo')->insert(array (
            0 => 
            array (
                'nombre' => 'Comercial',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            1 => 
            array (
                'nombre' => 'Tienda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ));
        
        
    }
}