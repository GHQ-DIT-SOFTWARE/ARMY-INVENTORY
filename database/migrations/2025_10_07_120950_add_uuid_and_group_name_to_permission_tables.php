<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('permissions')) {
            Schema::table('permissions', function (Blueprint $table): void {
                if (! Schema::hasColumn('permissions', 'uuid')) {
                    $table->uuid('uuid')->nullable()->index()->after('id');
                }

                if (! Schema::hasColumn('permissions', 'group_name')) {
                    $table->string('group_name')->nullable()->after('name');
                }
            });

            DB::table('permissions')
                ->select('id')
                ->whereNull('uuid')
                ->orWhere('uuid', '')
                ->orderBy('id')
                ->get()
                ->each(function (object $permission): void {
                    DB::table('permissions')
                        ->where('id', $permission->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                });

            DB::table('permissions')
                ->whereNull('group_name')
                ->update(['group_name' => 'legacy']);
        }

        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table): void {
                if (! Schema::hasColumn('roles', 'uuid')) {
                    $table->uuid('uuid')->nullable()->index()->after('id');
                }
            });

            DB::table('roles')
                ->select('id')
                ->whereNull('uuid')
                ->orWhere('uuid', '')
                ->orderBy('id')
                ->get()
                ->each(function (object $role): void {
                    DB::table('roles')
                        ->where('id', $role->id)
                        ->update(['uuid' => (string) Str::uuid()]);
                });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('permissions')) {
            Schema::table('permissions', function (Blueprint $table): void {
                if (Schema::hasColumn('permissions', 'uuid')) {
                    $table->dropIndex(['uuid']);
                    $table->dropColumn('uuid');
                }

                if (Schema::hasColumn('permissions', 'group_name')) {
                    $table->dropColumn('group_name');
                }
            });
        }

        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table): void {
                if (Schema::hasColumn('roles', 'uuid')) {
                    $table->dropIndex(['uuid']);
                    $table->dropColumn('uuid');
                }
            });
        }
    }
};

