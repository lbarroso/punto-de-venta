<?php

use App\Models\Product;
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
        Schema::create('codigos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Product::class)->constrained();
            $table->string('codigo',25)->nullable()->unique();
            
            /**
            *ALTER TABLE `codigos`
            *ADD CONSTRAINT `on_delete_product_cascade` 
            *FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codigos');
    }
};
