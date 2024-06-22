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
        Schema::table('issue_item_outs', function (Blueprint $table) {
            $table->integer('confirm_qty')->nullable();
            $table->string('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issue_item_outs', function (Blueprint $table) {
            $table->dropColumn('confirm_qty');
            $table->dropColumn('remarks');
        });
    }
};
