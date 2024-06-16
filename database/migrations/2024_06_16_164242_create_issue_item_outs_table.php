<?php
declare (strict_types = 1);
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
        Schema::create('issue_item_outs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('invoice_no')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->string('unit_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('sub_category')->nullable();
            // $table->unsignedBigInteger('unit_id')->nullable();
            // $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            // $table->unsignedBigInteger('category_id')->nullable();
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->unsignedBigInteger('sub_category')->nullable();
            // $table->foreign('sub_category')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->string('qty')->nullable();
            $table->string('sizes')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('issue_item_outs');
    }
};
