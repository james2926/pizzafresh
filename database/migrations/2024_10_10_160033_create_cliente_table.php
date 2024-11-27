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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->string('nombre_fiscal', 100);
            $table->string('cif', 20)->nullable();
            $table->string('email', 100);
            $table->date('fecha_nacimiento')->nullable();
            $table->integer('id_direccion_envio')->nullable();
            $table->integer('id_direccion_facturacion')->nullable();
            $table->integer('id_grupo');
            $table->string('codigo_envio', 100)->nullable();
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
        Schema::dropIfExists('cliente');
    }
};
