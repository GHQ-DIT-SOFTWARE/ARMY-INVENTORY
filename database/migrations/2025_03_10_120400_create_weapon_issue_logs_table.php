<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weapon_issue_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('weapon_inventory_id');
            $table->unsignedBigInteger('armory_id');
            $table->unsignedBigInteger('issued_by');
            $table->unsignedBigInteger('received_by')->nullable();
            $table->dateTime('issued_at');
            $table->dateTime('expected_return_at')->nullable();
            $table->dateTime('returned_at')->nullable();
            $table->string('status')->default('issued');
            $table->text('issue_notes')->nullable();
            $table->text('return_notes')->nullable();
            $table->timestamps();

            $table->foreign('weapon_inventory_id')->references('id')->on('weapon_inventories')->cascadeOnDelete();
            $table->foreign('armory_id')->references('id')->on('armories')->cascadeOnDelete();
            $table->foreign('issued_by')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('received_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weapon_issue_logs');
    }
};
