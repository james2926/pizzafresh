<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClienteTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cliente')->delete();
        
        \DB::table('cliente')->insert(array (
            0 => 
            array (
                'nombre' => 'John',
                'apellidos' => 'DOE',
                'nombre_fiscal' => 'John DOE',
                'cif' => NULL,
                'email' => 'pub@prestashop.com',
                'fecha_nacimiento' => '1970-01-15',
                'id_direccion_envio' => 8,
                'id_direccion_facturacion' => 9,
                'id_grupo' => 1,
                'codigo_envio' => NULL,
                'created_at' => '2023-02-22',
                'updated_at' => '2023-02-22',
            ),
            2 => 
            array (
                'nombre' => 'Hectorprueba',
                'apellidos' => 'GalindoPrueba',
                'nombre_fiscal' => 'Hectorprueba GalindoPrueba',
                'cif' => NULL,
                'email' => 'servipizza@gmail.com',
                'fecha_nacimiento' => '1985-03-02',
                'id_direccion_envio' => NULL,
                'id_direccion_facturacion' => NULL,
                'id_grupo' => 1,
                'codigo_envio' => NULL,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
            3 => 
            array (
                'nombre' => 'Prueba Cuenta',
                'apellidos' => 'Prueba cuenta',
                'nombre_fiscal' => 'Prueba Cuenta Prueba cuenta',
                'cif' => 'B78220670',
                'email' => 'info@gradoscomunicacion.com',
                'fecha_nacimiento' => NULL,
                'id_direccion_envio' => 656,
                'id_direccion_facturacion' => 657,
                'id_grupo' => 1,
                'codigo_envio' => NULL,
                'created_at' => '2023-03-31',
                'updated_at' => '2023-03-31',
            ),
        ));
    }
}