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
        Schema::create('pedido', function (Blueprint $table) {
            $table->id();
            $table->integer('nro')->nullable();
            $table->integer('id_prestashop')->nullable();
            $table->integer('id_cliente');
            $table->decimal('gastos_envio', 11)->default(0);
            $table->decimal('descuento', 11)->default(0);
            $table->dateTime('fecha')->useCurrent();
            $table->integer('id_estado')->default(1);
            $table->string('cod_barras', 32)->nullable();
            $table->dateTime('fecha_empaquetado')->nullable();
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
        Schema::dropIfExists('pedido');
    }
};
