<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_deployments', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('vehicle_inventory_id');
            $table->unsignedBigInteger('motor_pool_id');
            $table->unsignedBigInteger('issued_by');
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->dateTime('deployed_at');
            $table->dateTime('expected_return_at')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->string('status')->default('deployed');
            $table->text('deployment_notes')->nullable();
            $table->text('return_notes')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_inventory_id')->references('id')->on('vehicle_inventories')->cascadeOnDelete();
            $table->foreign('motor_pool_id')->references('id')->on('motor_pools')->cascadeOnDelete();
            $table->foreign('issued_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('operator_id')->references('id')->on('personnels')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_deployments');
    }
};
