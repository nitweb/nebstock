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
        Schema::table('wishlists', function (Blueprint $table) {
            // user_id nullable করো (guest এর জন্য)
            $table->unsignedBigInteger('user_id')->nullable()->change();
            // session_id যোগ করো
            $table->string('session_id')->nullable()->after('user_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropColumn('session_id');
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
