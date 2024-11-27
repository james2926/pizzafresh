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
        Schema::create('articulo', function (Blueprint $table) {
            $table->id();
            $table->integer('id_prestashop')->nullable();
            $table->string('nombre', 100);
            $table->string('ref', 100);
            $table->string('descripcion', 300);
            $table->integer('unidades_torre')->default(0);
            $table->integer('unidades_caja')->default(0);
            $table->integer('id_familia')->nullable();
            $table->integer('id_fabricante')->nullable();
            $table->boolean('venta_stock')->default(false);
            $table->decimal('peso', 11)->default(0);
            $table->integer('cantidad')->default(0);
            $table->integer('id_tipo_etiqueta')->nullable();
            $table->decimal('precio', 11)->default(0);
            $table->boolean('principal')->default(false);
            $table->boolean('ingrediente')->nullable()->default(false);
            $table->integer('id_produccion')->nullable();
            $table->integer('sorting_index')->nullable()->default(0);
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
        Schema::dropIfExists('articulo');
    }
};
