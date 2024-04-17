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
        Schema::create('cierres', function (Blueprint $table) {
            $table->id();
            $table->decimal('saldo_anterior', 10, 2);
            $table->decimal('entrada', 10, 2);
            $table->decimal('salida', 10, 2);
            $table->decimal('venta', 10, 2);
            $table->decimal('saldo_actual', 10, 2);            
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
        Schema::dropIfExists('cierres');
    }
};
