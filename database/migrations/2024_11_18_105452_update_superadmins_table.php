<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('superadmins', function (Blueprint $table) {
            $table->string('uuid')->nullable()->after('id');
            $table->string('avatar')->nullable()->after('password');
            $table->string('last_login')->nullable()->after('avatar');
            $table->tinyInteger('status')->nullable()->default(1)->after('last_login');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('superadmins', function (Blueprint $table) {
            //
        });
    }
};
