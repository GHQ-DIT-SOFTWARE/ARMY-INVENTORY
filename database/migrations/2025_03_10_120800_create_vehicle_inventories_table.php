<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_inventories', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('vehicle_id');
            $table->string('asset_number')->unique();
            $table->date('acquired_on')->nullable();
            $table->string('status')->default('in_pool');
            $table->unsignedBigInteger('current_motor_pool_id')->nullable();
            $table->dateTime('last_serviced_at')->nullable();
            $table->text('condition_notes')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->cascadeOnDelete();
            $table->foreign('current_motor_pool_id')->references('id')->on('motor_pools')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_inventories');
    }
};
