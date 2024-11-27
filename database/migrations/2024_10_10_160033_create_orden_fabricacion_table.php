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
        Schema::create('orden_fabricacion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('factor_inc');
            $table->boolean('urgencia')->default(false);
            $table->string('observaciones', 300)->nullable();
            $table->boolean('finalizada')->default(false);
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
        Schema::dropIfExists('orden_fabricacion');
    }
};
