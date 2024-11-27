<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticuloFabricanteTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('articulo_fabricante')->delete();
        
        \DB::table('articulo_fabricante')->insert(array (
            0 => 
            array (
                'nombre' => 'Pizzafresh',
                'created_at' => '2023-02-15',
                'updated_at' => '2023-07-20',
            ),
            1 => 
            array (
                'nombre' => 'Fumisan',
                'created_at' => '2024-05-15',
                'updated_at' => '2024-05-15',
            ),
            2 => 
            array (
                'nombre' => 'Gaviplas',
                'created_at' => '2024-09-04',
                'updated_at' => '2024-09-04',
            ),
            3 => 
            array (
                'nombre' => 'Bolsemack',
                'created_at' => '2024-09-04',
                'updated_at' => '2024-09-04',
            ),
            4 => 
            array (
                'nombre' => 'DS Smith',
                'created_at' => '2024-09-04',
                'updated_at' => '2024-09-04',
            ),
            5 => 
            array (
                'nombre' => 'Vega Baja Packaging',
                'created_at' => '2024-09-04',
                'updated_at' => '2024-09-04',
            ),
            6 => 
            array (
                'nombre' => 'Grafimur',
                'created_at' => '2024-09-04',
                'updated_at' => '2024-09-04',
            ),
        ));
        
        
    }
}