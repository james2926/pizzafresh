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
        Schema::create('produccion_articulo', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produccion');
            $table->integer('id_articulo');
            $table->integer('inventario');
            $table->integer('total_a_fabricar')->nullable()->default(0);
            $table->integer('etiquetas_impresas')->nullable()->default(0);
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
        Schema::dropIfExists('produccion_articulo');
    }
};
