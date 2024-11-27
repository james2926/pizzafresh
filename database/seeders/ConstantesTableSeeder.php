<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConstantesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('constantes')->delete();
        
        \DB::table('constantes')->insert(array (
            0 => 
            array (
                'incremento_inv' => 10,
                'total_gr_masa' => 146560.0,
                'capacidad_max' => 48.0,
                'created_at' => '2023-02-27',
                'updated_at' => '2024-04-30',
            ),
        ));
        
        
    }
}