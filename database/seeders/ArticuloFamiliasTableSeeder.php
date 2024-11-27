<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticuloFamiliasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('articulo_familias')->delete();
        
        \DB::table('articulo_familias')->insert(array (
            0 => 
            array (
                'nombre' => 'Amasado',
                'created_at' => '2023-02-15',
                'updated_at' => '2023-07-13',
            ),
            1 => 
            array (
                'nombre' => 'Bases de Pizzas',
                'created_at' => '2023-02-15',
                'updated_at' => '2024-02-22',
            ),
            2 => 
            array (
                'nombre' => 'Envases Plásitcos',
                'created_at' => '2023-02-15',
                'updated_at' => '2024-02-22',
            ),
            3 => 
            array (
                'nombre' => 'Envases Cartón',
                'created_at' => '2023-02-15',
                'updated_at' => '2024-02-22',
            ),
            4 => 
            array (
                'nombre' => 'Etiqueta',
                'created_at' => '2024-09-04',
                'updated_at' => '2024-09-04',
            ),
        ));
        
        
    }
}