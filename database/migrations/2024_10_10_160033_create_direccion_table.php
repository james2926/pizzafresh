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
        Schema::create('direccion', function (Blueprint $table) {
            $table->id();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 300)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->integer('id_provincia')->nullable();
            $table->string('codigo_postal', 10)->nullable();
            $table->integer('id_pais')->nullable();
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
        Schema::dropIfExists('direccion');
    }
};
