<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(AccionLogTableSeeder::class);
        $this->call(ArticuloFabricanteTableSeeder::class);
        $this->call(PaisTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TipoEtiquetaTableSeeder::class);
        $this->call(RolTableSeeder::class);
        $this->call(EstadoPedidoTableSeeder::class);
        $this->call(ConstantesTableSeeder::class);
        $this->call(ArticuloFamiliasTableSeeder::class);
        $this->call(ArticuloTableSeeder::class);
        $this->call(ClienteTableSeeder::class);
        $this->call(ArticuloRecetaTableSeeder::class);
        $this->call(ClienteGrupoTableSeeder::class);
        $this->call(TipoClienteTableSeeder::class);
    }
}
