<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('vehicle_category_id')->nullable();
            $table->string('name');
            $table->string('variant')->nullable();
            $table->string('image_path')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->string('engine_type')->nullable();
            $table->decimal('engine_power_hp', 10, 2)->nullable();
            $table->decimal('max_speed_kph', 8, 2)->nullable();
            $table->decimal('range_km', 8, 2)->nullable();
            $table->decimal('fuel_capacity_l', 10, 2)->nullable();
            $table->decimal('weight_tons', 8, 3)->nullable();
            $table->unsignedInteger('crew_capacity')->nullable();
            $table->unsignedInteger('passenger_capacity')->nullable();
            $table->text('armament')->nullable();
            $table->text('armor')->nullable();
            $table->text('communication_systems')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_category_id')->references('id')->on('vehicle_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
