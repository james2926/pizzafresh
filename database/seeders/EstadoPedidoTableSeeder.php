<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EstadoPedidoTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('estado_pedido')->delete();
        
        \DB::table('estado_pedido')->insert(array (
            0 => 
            array (
                'nombre' => 'Pendiente',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            1 => 
            array (
                'nombre' => 'Completado',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            2 => 
            array (
                'nombre' => 'Parcial',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
            3 => 
            array (
                'nombre' => 'Merma',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ),
        ));
        
        
    }
}