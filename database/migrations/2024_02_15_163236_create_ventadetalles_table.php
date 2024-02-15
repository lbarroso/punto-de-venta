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
        Schema::create('ventadetalles', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->integer('venta_id')->default(0);
            $table->string('codbarras',25)->nullable();
            $table->string('artdesc')->nullable();
            $table->decimal('artprcosto', 10, 2)->default(0);
            $table->decimal('artprventa', 10, 2)->default(0);
            $table->decimal('cantidad', 10, 2)->default(0);            
            $table->string('pvsession')->nullable();
            $table->integer('number_id')->default(0); // cobro en espera            
            // $table->foreignId('venta_id')->constrained('ventas');
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
        Schema::dropIfExists('ventadetalles');
    }
};
