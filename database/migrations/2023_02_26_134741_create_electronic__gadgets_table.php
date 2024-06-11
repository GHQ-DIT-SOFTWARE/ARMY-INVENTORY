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
        Schema::create('electronic__gadgets', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->string('serial_no')->nullable();
            $table->tinyInteger('status')->default('1');
            $table->integer('image');
            $table->integer('category_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('electronic__gadgets');
    }
};
