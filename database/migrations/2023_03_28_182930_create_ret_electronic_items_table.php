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
        Schema::create('ret_electronic_items', function (Blueprint $table) {
            $table->id();
            $table->integer('rank_id')->nullable();
            $table->string('svcnumber')->nullable();
            $table->string('surname')->nullable();
            $table->string('gender')->nullable();
            $table->string('mobile')->nullable();
            $table->string('othernames')->nullable();
            $table->string('email')->nullable();
            $table->string('product_name')->nullable();
            $table->string('item_location')->nullable();
            $table->string('serial_no')->nullable();
            $table->string('receive_date')->nullable();
            $table->string('user_receiver')->nullable();
            $table->string('status')->nullable()->comment('Returned=1');
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
        Schema::dropIfExists('ret_electronic_items');
    }
};
