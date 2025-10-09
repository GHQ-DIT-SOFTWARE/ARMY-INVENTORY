<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personnels', function (Blueprint $table) {
            if (! Schema::hasColumn('personnels', 'unit_id')) {
                $table->foreignId('unit_id')
                    ->nullable()
                    ->after('rank_id')
                    ->constrained('units')
                    ->nullOnDelete();
            }

            if (! Schema::hasColumn('personnels', 'unit_name')) {
                $table->string('unit_name')->nullable()->after('unit_id');
            }

            if (! Schema::hasColumn('personnels', 'height')) {
                $table->string('height')->nullable()->after('gender');
            }

            if (! Schema::hasColumn('personnels', 'virtual_mark')) {
                $table->string('virtual_mark')->nullable()->after('height');
            }
        });
    }

    public function down(): void
    {
        Schema::table('personnels', function (Blueprint $table) {
            if (Schema::hasColumn('personnels', 'unit_id')) {
                $table->dropForeign(['unit_id']);
                $table->dropColumn('unit_id');
            }

            if (Schema::hasColumn('personnels', 'unit_name')) {
                $table->dropColumn('unit_name');
            }

            if (Schema::hasColumn('personnels', 'height')) {
                $table->dropColumn('height');
            }

            if (Schema::hasColumn('personnels', 'virtual_mark')) {
                $table->dropColumn('virtual_mark');
            }
        });
    }
};
