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
        Schema::create('pedido_old', function (Blueprint $table) {
            $table->id();
            $table->integer('nro')->nullable();
            $table->integer('id_prestashop')->nullable();
            $table->integer('id_cliente');
            $table->decimal('gastos_envio', 11)->default(0);
            $table->decimal('descuento', 11)->default(0);
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
        Schema::dropIfExists('pedido_old');
    }
};
