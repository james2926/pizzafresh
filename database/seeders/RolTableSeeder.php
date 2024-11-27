<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('rol')->delete();
        
        \DB::table('rol')->insert(array (
            0 => 
            array (
                'descripcion' => 'Administrador',
                'created_at' => '2022-06-07',
                'updated_at' => '2022-06-07',
            ),
            1 => 
            array (
                'descripcion' => 'Administracion',
                'created_at' => '2023-02-15',
                'updated_at' => '2023-02-15',
            ),
        ));
        
        
    }
}