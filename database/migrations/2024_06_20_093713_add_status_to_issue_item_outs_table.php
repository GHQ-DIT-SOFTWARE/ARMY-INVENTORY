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
            $table->string('status')->nullable()->comment('1=issued,0=pending');
            // $table->date('password_changed_at')->nullable()->after('password');
            // $table->date('password_expiry')->nullable()->after('status');
            // $table->string('otp_code')->nullable()->after('profile_photo_path');
            // $table->string('code')->nullable()->after('email_verified_at');
            // $table->string('phone_number')->nullable()->after('status');
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
            // $table->dropColumn('password_changed_at');
            // $table->dropColumn('password_expiry');
            // $table->dropColumn('gender');
            // $table->dropColumn('code');
            // $table->dropColumn('phone_number');
        });
    }
};
