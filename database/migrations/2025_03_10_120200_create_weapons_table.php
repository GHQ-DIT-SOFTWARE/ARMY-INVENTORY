<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weapons', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('weapon_category_id')->nullable();
            $table->string('name');
            $table->string('variant')->nullable();
            $table->string('image_path')->nullable();
            $table->string('caliber')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->decimal('barrel_length_mm', 8, 2)->nullable();
            $table->decimal('overall_length_mm', 8, 2)->nullable();
            $table->decimal('weight_kg', 8, 3)->nullable();
            $table->decimal('muzzle_velocity_mps', 8, 2)->nullable();
            $table->decimal('rate_of_fire_rpm', 8, 2)->nullable();
            $table->decimal('effective_range_m', 8, 2)->nullable();
            $table->decimal('maximum_range_m', 8, 2)->nullable();
            $table->text('configuration')->nullable();
            $table->text('sight_system')->nullable();
            $table->text('ammunition_types')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('weapon_category_id')->references('id')->on('weapon_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weapons');
    }
};
