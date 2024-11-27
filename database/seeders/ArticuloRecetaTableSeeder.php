<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticuloRecetaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('articulo_receta')->delete();
        
        \DB::table('articulo_receta')->insert(array (
            0 => 
            array (
                'id' => 1,
                'id_articulo' => 1,
                'id_ingrediente' => 1,
                'cantidad' => 123,
                'created_at' => '2023-02-16',
                'updated_at' => '2023-02-16',
            ),
            1 => 
            array (
                'id' => 4,
                'id_articulo' => 28,
                'id_ingrediente' => 38,
                'cantidad' => 5,
                'created_at' => '2023-09-22',
                'updated_at' => '2023-09-22',
            ),
            2 => 
            array (
                'id' => 5,
                'id_articulo' => 10,
                'id_ingrediente' => 10,
                'cantidad' => 1,
                'created_at' => '2024-01-15',
                'updated_at' => '2024-01-15',
            ),
            3 => 
            array (
                'id' => 6,
                'id_articulo' => 6,
                'id_ingrediente' => 27,
                'cantidad' => 10,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            4 => 
            array (
                'id' => 7,
                'id_articulo' => 6,
                'id_ingrediente' => 70,
                'cantidad' => 1,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            5 => 
            array (
                'id' => 8,
                'id_articulo' => 6,
                'id_ingrediente' => 72,
                'cantidad' => 5,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            6 => 
            array (
                'id' => 9,
                'id_articulo' => 6,
                'id_ingrediente' => 65,
                'cantidad' => 5,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            7 => 
            array (
                'id' => 10,
                'id_articulo' => 11,
                'id_ingrediente' => 24,
                'cantidad' => 20,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            8 => 
            array (
                'id' => 11,
                'id_articulo' => 11,
                'id_ingrediente' => 69,
                'cantidad' => 1,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            9 => 
            array (
                'id' => 12,
                'id_articulo' => 11,
                'id_ingrediente' => 72,
                'cantidad' => 4,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            10 => 
            array (
                'id' => 13,
                'id_articulo' => 11,
                'id_ingrediente' => 64,
                'cantidad' => 4,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            11 => 
            array (
                'id' => 14,
                'id_articulo' => 19,
                'id_ingrediente' => 23,
                'cantidad' => 20,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            12 => 
            array (
                'id' => 15,
                'id_articulo' => 19,
                'id_ingrediente' => 68,
                'cantidad' => 1,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            13 => 
            array (
                'id' => 16,
                'id_articulo' => 19,
                'id_ingrediente' => 72,
                'cantidad' => 4,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
            14 => 
            array (
                'id' => 17,
                'id_articulo' => 19,
                'id_ingrediente' => 63,
                'cantidad' => 4,
                'created_at' => '2024-09-05',
                'updated_at' => '2024-09-05',
            ),
        ));
        
        
    }
}