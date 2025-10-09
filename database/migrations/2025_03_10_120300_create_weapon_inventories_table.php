<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weapon_inventories', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('weapon_id');
            $table->string('weapon_number')->unique();
            $table->date('acquired_on')->nullable();
            $table->string('status')->default('in_store');
            $table->unsignedBigInteger('current_armory_id')->nullable();
            $table->dateTime('last_audited_at')->nullable();
            $table->text('condition_notes')->nullable();
            $table->timestamps();

            $table->foreign('weapon_id')->references('id')->on('weapons')->cascadeOnDelete();
            $table->foreign('current_armory_id')->references('id')->on('armories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weapon_inventories');
    }
};
