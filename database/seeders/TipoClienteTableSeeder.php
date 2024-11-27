<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TipoClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('tipo_cliente')->delete();
        
        \DB::table('tipo_cliente')->insert(array (
            0 => 
            array (
                'descripcion' => 'Refrigerado',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            1 => 
            array (
                'descripcion' => 'Internet',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            2 => 
            array (
                'descripcion' => 'Comarca',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            3 => 
            array (
                'descripcion' => 'Recoger en tienda',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ));
    }
}
