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
        Schema::create('personnels', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('rank_id')->nullable();
            $table->foreign('rank_id')->references('id')->on('ranks')->onDelete('cascade');
            $table->string('svcnumber')->nullable();
            $table->string('surname')->nullable();
            $table->string('othernames')->nullable();
            $table->string('first_name')->nullable();
            $table->string('initial')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->unsignedBigInteger('arm_of_service')->nullable();
            $table->foreign('arm_of_service')->references('id')->on('services')->onDelete('cascade');
            $table->string('service_category')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('personnel_image')->nullable();
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('personnels');
    }
};
