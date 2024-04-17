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
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');             // Campo para la fecha de la compra
            $table->decimal('total', 8, 2);    // Campo para el total de la compra con dos decimales
            $table->string('status')->default('A');
            $table->integer('prvcve')->default(1);
            $table->text('comentarios')->nullable(); // Campo para comentarios, opcional            
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
        Schema::dropIfExists('entradas');
    }
};
