<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_articulo', function (Blueprint $table) {
            $table->id();
            $table->integer('id_orden');
            $table->integer('id_articulo');
            $table->integer('inventario_inicial');
            $table->integer('total_pedidos');
            $table->integer('total_fabricar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_articulo');
    }
};
