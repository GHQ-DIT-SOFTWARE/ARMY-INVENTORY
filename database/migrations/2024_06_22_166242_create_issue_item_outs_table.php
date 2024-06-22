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
            $table->string('status')->nullable()->comment('1=issued,0=pending');
            $table->date('date')->nullable();
            $table->date('confirmed_issued')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->string('unit_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('qty')->nullable();
            $table->string('sizes')->nullable();
            $table->text('description')->nullable();
            $table->integer('confirm_qty')->nullable();
            $table->string('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
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
