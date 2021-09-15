<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->enum('size', ['S', 'M', 'L'])->default("S");
            $table->integer('inventory');
            $table->date('boarding');
            $table->unsignedBigInteger('brand_id');
            $table->boolean('disabled')->default(false);
            $table->timestamps();

            $table->foreign('brand_id')->references('id')
            ->on('brands')->onDelete('no action');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
