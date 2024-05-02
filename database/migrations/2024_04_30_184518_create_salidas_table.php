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
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->integer('ctecve')->default(1);
            $table->text('comentarios')->nullable();
            $table->string('user_name')->nullable();
            $table->string('status', 2)->default('A');        
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
        Schema::dropIfExists('salidas');
    }
};
